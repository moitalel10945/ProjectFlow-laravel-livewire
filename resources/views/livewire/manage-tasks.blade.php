<div class="p-8" >
    <h1 class="font-bold text-2xl">Project tasks:{{-- {{ $project->name }} --}}</h1>
    <input wire:model.live.debounce.500ms="search" class="m-2 bg-gray-300 px-8 py-2 rounded border border-gray-500" placeholder="Search your tasks here">
    <ul>
        @if (session('success'))
           <span class="text-green-500 mt-2">{{ session('success') }}</span>
        @endif
        
             @forelse ($tasks as $task)
             
                <li wire:key="{{ $task->id }}">
                    @if ($task->status)

                    <input wire:click="toggle({{ $task->id }})" type="checkbox" checked>
                    <p class="text-green-500  inline-block">{{ $task->title }}</p>

                    @else

                    <input wire:click="toggle({{ $task->id }})" type="checkbox">
                    <p class="inline-block">{{ $task->title }}</p>

                    @endif
                    
                    
                    <button wire:click.prevent="deleteTask({{ $task->id }})" class="bg-red-500 text-white px-1 py-1 rounded-xl text-xs hover:bg-red-300 cursor-pointer ">Delete</button>
                 <p>{{ $task->duedate }}</p>
                </li>
                
             
             
            
                
            @empty
               <p>No Tasks Found, yet to be added.</p> 
            @endforelse
            {{ $tasks->links() }}  
        
        
        <a class="bg-blue-500 px-2 py-1 text-white rounded-xl" href="/dashboard">Back</a>
    </ul>
    <br/>
    <form wire:submit.prevent="createTask" wire:key="task-{{  $latestId}}">
        <div class="mt-2">
            <span>Task Title:</span>
            <input wire:model="title" class="bg-gray-300 px-4 py-2 rounded border border-gray-500" placeholder="Title..">
            @error('title')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
    
        <div class="mt-2">
            <span>Task duedate:</span>
            <input  wire:model="duedate" type="date" class="bg-gray-300 px-4 py-2 rounded border border-gray-500" placeholder="Title..">
            @error('duedate')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>


        {{-- - <div class="mt-2">
            <span>Task Status:</span>
            <select  wire:model="status" class="bg-gray-300 px-6 py-2 rounded border border-gray-500">
                <option>Select</option>
                <option>Done</option>
                <option>Pending</option>
            </select>
            @error('status')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>--}}
        <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded-xl hover:bg-green-300 cursor-pointer">Add Task</button>
        
    </form>
</div>
