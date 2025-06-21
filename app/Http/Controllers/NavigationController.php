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
        $navigation = new Navigation();
        $navigation->name = $request->name;
        $navigation->parent_id = $request->parent_id;
        $navigation->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'No IDs provided.'
            ], 422);
        }

        Navigation::whereIn('id', $ids)
            ->where('is_deletable', true)
            ->delete();

        return response()->json(['success' => true]);
    }
}
