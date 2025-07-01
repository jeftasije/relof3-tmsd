<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
    <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
      <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">{{ __('our_team_title') }}</h2>
      <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">
        {{ __('our_team_subtitle') }}
      </p>
    </div>
    <div class="flex flex-wrap justify-center gap-8 lg:gap-16">
    @foreach($visibleEmployees as $employee)
        <div class="text-center text-gray-500 dark:text-gray-400 w-64">
        <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ asset($employee->image_path) }}" alt="Employee Avatar">
        <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            <a href="#">{{ $employee->name }}</a>
        </h3>
        <p>{{ $employee->position }}</p>
        </div>
    @endforeach
    </div>

  </div>
</section>
