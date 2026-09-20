@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#0a0f1d] border border-gray-600 text-gray-200 focus:border-[#FFC209] focus:ring focus:ring-[#FFC209] focus:ring-opacity-50 rounded-md shadow-sm placeholder-gray-500']) }}>

