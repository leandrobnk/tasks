<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Tarefas') }}
        </h2>
    </x-slot>


    <div class="py-12">



        <div class="lg:w-2/4 mx-auto py-8 px-6 bg-white rounded-xl">
        <h1 class="font-bold text-4xl text-center mb-8">Gerenciado de Tarefas</h1>
            @if(count($errors))

            <div class="alert alert-danger">
                <ul>

                    @foreach($errors->all() as $error)

                    <div class="relative items-center w-full px-5 py-1 mx-auto md:px-12 lg:px-24 max-w-7xl">
                        <div class="p-6 border-l-4 border-red-500 -6 rounded-r-xl bg-red-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm text-red-600">
                                        <p>{{ $error }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </ul>

            </div>

            @endif
            @session('message')
            <div class="relative items-center w-full px-5 py-1 mx-auto md:px-12 lg:px-24 max-w-7xl">
                <div class="p-6 border-l-4 border-green-500 -6 rounded-r-xl bg-green-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-green-600">
                                <p>{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsession
            <div class="mb-6">
                <form class="flex flex-col space-y-4" method="POST" action="{{ route('task.store')  }}">
                    @csrf
                    <input name="title" type="text" class="py-3 px-4 bg-gray-100 rounded-xl border-gray-300 focus:border-teal-200 focus:outline-none" placeholder="Digite o nome tarefa">
                    <textarea name="description" placeholder="Escreva o que será feito nesta tarefa" class="py-3 px-4 bg-gray-100 rounded-xl border-gray-300 focus:border-teal-200 focus:outline-none"></textarea>

                    <button type="submit" class="w-22 py-4 px-8 hover:bg-green-700 bg-green-400 text-white text-lg text-bold rounded-xl">Adicionar</button>
                </form>
            </div>
            <hr>
            <div class="mt-2">
                @if(empty($tasks) == false)
                @foreach ($tasks as $task)
                <div @class([ 'py-4 flex items-center border-b border-gray-300 px-3' , $task->is_done == 1 ? 'bg-green-50 line-through' : ''
                    ])>
                    <div class="flex-1 pr-8">
                        <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                        <p class="text-gray-500">{{ $task->description }}</p>
                    </div>

                    <div class="flex space-x-3">
                        <form method="POST" action="{{ route('task.store') }}/{{ $task->id }}">
                            @csrf
                            @method('PATCH')
                            <button @class([ 'py-2 px-2 bg-green-400 text-white rounded-xl' , $task->is_done == 1 ? 'bg-orange-400' : ''
                                ])>
                                @if($task->is_done == 0)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M9.75 3.5A2.75 2.75 0 0 0 7 6.25v5.19l2.22-2.22a.75.75 0 1 1 1.06 1.06l-3.5 3.5a.75.75 0 0 1-1.06 0l-3.5-3.5a.75.75 0 1 1 1.06-1.06l2.22 2.22V6.25a4.25 4.25 0 0 1 8.5 0v1a.75.75 0 0 1-1.5 0v-1A2.75 2.75 0 0 0 9.75 3.5Z" clip-rule="evenodd" />
                                </svg>
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('task.store') }}/{{ $task->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="py-2 px-2 bg-red-400 text-white rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                @else
                <p>Não existem tarefas registradas</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
