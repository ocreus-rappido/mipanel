<nav class="bg-white border-b border-gray-100 px-6 py-2.5 flex items-center justify-between w-full">
    <!-- LADO IZQUIERDO: Espacio de separación o título del sistema -->
    <div class="flex items-center gap-4">
        <!-- Vacío para mantener el perfil a la derecha -->
    </div>

    <!-- LADO DERECHO: PERFIL DEL USUARIO (ORLANDO) -->
    <div class="flex items-center gap-2 ml-auto">
        <div class="w-8 h-8 rounded-full bg-[#0284c7] text-white font-bold flex items-center justify-center text-xs shadow-sm">
            {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
        </div>
        <span class="text-xs font-bold text-gray-700 capitalize">
            {{ Auth::user()->name ?? 'orlando' }}
        </span>
    </div>
</nav>