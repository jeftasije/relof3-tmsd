<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Navigation;
use Illuminate\Support\Facades\DB;

class NavigationController extends Controller
{
    public function saveOrder(Request $request)
    {
        $items = $request->input('items');

        try {
            DB::transaction(function () use ($items) {
                foreach ($items as $item) {
                    $navigation = Navigation::findOrFail($item['id']);
                    $navigation->update([
                        'order' => $item['order']
                    ]);
                }
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        if ($request->parent_id) {
            $parentNav = Navigation::find($request->parent_id);

            if (
                $parentNav &&
                !$parentNav->is_deletable &&
                $parentNav->redirect_url &&
                $parentNav->is_active
            ) {
                $redirectUrlToMove = $parentNav->redirect_url;
                $parentNav->redirect_url = null;
                $parentNav->save();

                $newParentNav = new Navigation();
                $newParentNav->name = $parentNav->name;
                $newParentNav->name_en = $parentNav->name_en;
                $newParentNav->name_cy = $parentNav->name_cy;
                $newParentNav->parent_id = $parentNav->id;
                $newParentNav->is_active = true;
                $newParentNav->save();

                $childNav = new Navigation();
                $childNav->name = $parentNav->name;
                $childNav->name_en = $parentNav->name_en;
                $childNav->name_cy = $parentNav->name_cy;
                $childNav->parent_id = $newParentNav->id;
                $childNav->redirect_url = $redirectUrlToMove;
                $childNav->is_deletable = false;
                $childNav->is_active = true;
                $childNav->save();
            }
        }

        $navigation = new Navigation();
        $navigation->name = $request->name;
        $navigation->parent_id = $request->parent_id;
        $navigation->is_active = false;
        $navigation->save();

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'No ID provided.'
            ], 422);
        }

        $navigation = Navigation::find($id);

        if (!$navigation) {
            return response()->json([
                'success' => false,
                'message' => 'Navigation not found.'
            ], 404);
        }

        $children = Navigation::where('parent_id', $id)->get();

        foreach ($children as $child) {
            if (!$child->is_deletable) {
                $mainNavigation = Navigation::find($navigation->parent_id);

                if ($mainNavigation) {
                    $otherSubnavigation = Navigation::where('parent_id', $mainNavigation->id)
                        ->where('id', '!=', $navigation->id)
                        ->first();

                    if ($otherSubnavigation) {
                        $child->parent_id = $otherSubnavigation->id;
                        $child->save();
                    } else {
                        $mainNavigation->redirect_url = $child->redirect_url;
                        $mainNavigation->save();
                        $child->delete();
                    }
                }
            } else {
                $child->delete();
            }
        }

        if ($navigation->is_deletable) {
            $navigation->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Navigation is not deletable.'
            ], 403);
        }
    }

    public function edit(Request $request, $id)
    {
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'No ID provided.'
            ], 422);
        }

        $navigation = Navigation::find($id);

        if($navigation){
            $navigation->name = $request->name;
            $navigation->save();
            return response()->json(['success' => true]);
        }
    }
}
