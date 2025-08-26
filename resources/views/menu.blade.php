<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head.tailwindcss />

<body class="bg-orange-100 dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
  <div>menu test</div>

  <div class="bg-white dark:bg-gray-800 rounded-lg px-6 py-8 ring shadow-xl ring-gray-900/5">
    <div>
      <span class="inline-flex items-center justify-center rounded-md bg-indigo-500 p-2 shadow-lg">
        <svg class="h-6 w-6 stroke-white">
          <!-- ... -->
        </svg>
      </span>
    </div>
    <h3 class="text-gray-900 dark:text-white mt-5 text-base font-medium tracking-tight ">Writes upside-down</h3>
    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm ">
      The Zero Gravity Pen can be used to write in any orientation, including upside-down. It even works in outer space.
    </p>
  </div>

</body>

</html>