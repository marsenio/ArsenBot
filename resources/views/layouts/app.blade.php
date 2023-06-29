@props(['exibirmenu' => '1', 'atendimento' => '0'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="img/favicon.png">

    <title>{{ $atendimento == '0' ? '' : '(' . $atendimento . ')' }}
        {{ config('app.name', 'Laravel') . ' | Versão ' . App\Helpers\Helper::$versao }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>

<body x-data="{
    sidebarOpen: false,
    lProfile: false,
    lEstabelecimento: false,
    menuWhatsApp: false,
    menuCadastro: false,
}" class="bg-[#e2e2ef]" style="font-family: 'Source Sans Pro', sans-serif;">

    {{-- MENU TOPO --}}
    <nav class="grid grid-cols-5 bg-[#263151]">
        {{-- ICONE DO MENU --}}
        <div class="col-span-1">
            <div class="flex items-center justify-start h-full px-2 py-2 space-x-4">
                <div class="">
                    <a href="" x-on:click.prevent="sidebarOpen = true">
                        <x-icon.menu class="h-6 text-white sm:h-8 md:h-10" />
                    </a>
                </div>
            </div>
        </div>
        {{-- TITULO DA ROTINA ATUAL --}}
        <div class="col-span-3">
            <div
                class="items-center justify-center h-full px-3 py-3 font-semibold leading-5 text-center text-white uppercase lg:text-3xl md:text-2xl sm:text-xl xl:text-4xl sm:flex sm:space-x-2">
                {{-- TITULO --}}
                <div>{{ $titulo }}</div>
                {{-- SUBTITULO --}}
                <div class="font-normal text-md sm:text-xl md:text-2xl lg:text-3xl xl:text-4xl sm:font-semibold">
                    {{ isset($subtitulo) ? $subtitulo : '' }}
                </div>
            </div>
        </div>
        {{-- DADOS DO USUÁRIO CONECTADO | ICONE CONFIGURAÇÃO | PERFIL USUÁRIO --}}
        <div class="col-span-1">
            <div class="flex items-center justify-end h-full px-2 py-2 space-x-1">
                {{-- ICONE DO ESTABELECIMENTO --}}
                <div class="" @click.outside="lEstabelecimento = false">
                    <a x-on:click.prevent="lEstabelecimento = !lEstabelecimento">
                        <x-icon.estabelecimento class="h-6 text-white sm:h-8" />
                    </a>
                </div>
                {{-- ICONE DO PERFIL --}}
                <div class="" @click.outside="lProfile = false">
                    <a x-on:click.prevent="lProfile = !lProfile">
                        <x-icon.perfil class="h-6 text-white sm:h-8" />
                    </a>
                </div>

                @if (isset(Auth::user()->name))
                    {{-- TEXTO COM NOME DO USUARIO E TIPO DE PERMISSÃO - A PARTIR DO SM --}}
                    <div class="flex-col hidden leading-none text-center text-white sm:flex">
                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-xs font-medium capitalize">{{ Auth::user()->tipo }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();this.closest('form').submit();">
                                <div class="text-xs leading-none">
                                    Sair
                                </div>
                            </a>
                        </form>
                    </div>
                @endif


                {{-- DIV APONTANDO PARA O ESTABELECIMENTO --}}
                <div class="absolute bg-white h-3 mt-11 w-3 rotate-45 border-t border-l border-[#3c3c6f] z-20  sm:hidden"
                    x-transition x-show="lEstabelecimento" style="display:none;margin-left: 0px; right: 42px">
                </div>
                {{-- ESTABELECIMENTO --}}
                <div class="absolute bg-white border border-[#3c3c6f] flex h-20 px-2 right-0 rounded-md sm:hidden w-auto leading-5"
                    x-transition x-show="lEstabelecimento" style="display:none;margin-top: 123px;">
                    <div class="flex flex-col justify-center">
                        <div class="font-semibold">
                            <span>Estabelecimento:</span>
                            <span class="text-green-700">Online</span>
                        </div>
                        <div>
                            <span class="font-semibold">Motivo:</span>
                            <span>Dentro do horário de atendimento e Gestor de Pedidos Aberto</span>
                        </div>
                    </div>
                </div>

                @if (isset(Auth::user()->name))
                    {{-- DIV APONTANDO PARA O PROFILE --}}
                    <div class="absolute bg-white h-3 mt-11 right-3.5 w-3 rotate-45 border-t border-l border-[#3c3c6f] z-20  sm:hidden"
                        x-transition x-show="lProfile" style="display:none;margin-left: 0px;"></div>
                    {{-- PROFILE --}}
                    <div class="absolute bg-white h-20 p-2 rounded-md w-auto border border-[#3c3c6f] right-0 flex items-center justify-center sm:hidden"
                        x-transition x-show="lProfile" style="display:none;margin-top: 123px;">
                        <div>
                            {{-- DIV USUARIO CONECTADO --}}
                            <div class="text-xs font-semibold leading-5 text-gray-600">Usuário Conectado:</div>
                            <div class="leading-4">
                                <div class="font-semibold text-center">{{ Auth::user()->name }}</div>
                                <div class="text-xs font-medium text-center capitalize">
                                    {{ Auth::user()->tipo }}
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();this.closest('form').submit();">
                                        <div class="text-xs font-semibold leading-none text-center text-blue-700">
                                            Sair
                                        </div>
                                    </a>
                                </form>
                            </div>

                        </div>
                    </div>
                @endif


            </div>
        </div>
    </nav>

    {{-- MENU LATERAL ESQUERDO --}}
    <div x-show="sidebarOpen" style="display:none;">
        <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex" :class="sidebarOpen ? '' : 'hidden'"
            style="display: none">
            <div @click="sidebarOpen = false" x-show="sidebarOpen"
                x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
                x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0"
                style="display: none;">
                <div x-show="sidebarOpen" class="absolute inset-0 bg-gray-600 opacity-75" style="display: none">

                </div>
            </div>
            <div x-show="sidebarOpen" x-description="Off-canvas menu, show/hide based on off-canvas menu state."
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                class="relative flex flex-col w-80 bg-[#263151]" style="display: none;">

                {{-- BOTÃO FECHAR --}}
                <div class="absolute top-0 right-0 mt-2 mr-2 cursor-pointer" @click="sidebarOpen = false">
                    <x-icon.close class="h-6 text-white" />
                </div>

                <div class="pt-5 overflow-y-auto">

                    {{-- LOGO E TITULO --}}
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-full">
                            {{-- LOGO --}}
                            <div class="">
                                <img class="h-10" src="\img\ArsenBotLadoTransparente.png" alt=""
                                    id="imgLogoWhite">
                            </div>

                        </div>
                    </div>

                    <hr class="py-0 my-4 border-b border-gray-100 opacity-25" />

                    {{-- MENU INÍCIO --}}
                    <nav class="px-2 mt-5 space-y-1">

                        <a href={{ route('home') }}
                            class="group flex items-center px-2 py-2 font-medium text-white transition duration-150 ease-in-out rounded-md hover:bg-white hover:text-[#263151]">
                            <svg class="w-6 h-6 mr-3 text-white group-hover:text-[#263151] transition duration-150 ease-in-out"
                                stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6">
                                </path>
                            </svg>
                            Início
                        </a>

                        <a href='' @click.prevent="menuCadastro = !menuCadastro"
                            class="group flex items-center px-2 py-2 font-medium text-white transition duration-150 ease-in-out rounded-md hover:bg-white hover:text-[#263151]">
                            <div>
                                <x-icon.cadastro class="w-6 h-6 mr-3 text-white group-hover:text-[#263151]" />
                            </div>
                            <div class="w-full">Cadastros Gerais</div>
                            <div>
                                <x-icon.seta-baixo x-show="menuCadastro == false" />
                                <x-icon.seta-cima style="display: none" x-show="menuCadastro" />
                            </div>
                        </a>

                        <a href={{ route('home') }} x-show="menuCadastro" style="display: none"
                            class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out rounded-md group ml-9 
                        hover:bg-white hover:text-[#263151]">
                            <div class="">
                                Atendentes
                            </div>
                        </a>

                        <a href={{ route('home') }} x-show="menuCadastro" style="display: none"
                            class="flex items-center px-2 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out rounded-md ml-9 
                            hover:bg-white hover:text-[#263151]">
                            <div class="">
                                Contatos
                            </div>
                        </a>

                        {{-- WHATSAPP --}}
                        <a href='' @click.prevent="menuWhatsApp = !menuWhatsApp"
                            class="group flex items-center px-2 py-2 font-medium text-white transition duration-150 ease-in-out rounded-md hover:bg-white hover:text-[#263151]">
                            <div>
                                <x-icon.whatsappbranco class="w-6 h-6 mr-3 text-white group-hover:text-[#263151] fill-current" />
                            </div>
                            <div class="w-full">WhatsApp</div>
                            <div>
                                <x-icon.seta-baixo x-show="menuWhatsApp == false" />
                                <x-icon.seta-cima style="display: none" x-show="menuWhatsApp" />
                            </div>
                        </a>

                        {{-- RESPOSTA RAPIDA --}}
                        <a href='{{ route('home') }}' x-show="menuWhatsApp" style="display: none"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out rounded-md ml-9 hover:bg-white hover:text-[#263151]">
                            <div class="">
                                Resposta Rápida
                            </div>
                        </a>

                        {{-- CONFIGURAÇÃO --}}
                        <a href='{{ route('home') }}' x-show="menuWhatsApp" style="display: none"
                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out rounded-md ml-9 hover:bg-white hover:text-[#263151]">
                            <div class="">
                                Webhook
                            </div>
                        </a>


                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="min-h-screen bg-gray-100">
        {{-- Page Content --}}
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @include('popper::assets')

    @livewireScripts

</body>

</html>
