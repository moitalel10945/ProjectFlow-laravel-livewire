<div>
    @if (session('success'))
    <span class="text-green-500">{{session('success')}}</span>
    
    @endif
    
    <form wire:submit.prevent="createProject" wire:key="{{ $projects->count() }}">
        <div class="mt-3">
          <label>Project Name:</label>
          <input wire:model="name" placeholder="Project Name.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
          @error('name')
              <span class="text-red-500 xs">{{$message}}</span>
          @enderror
        </div>
        <div class="mt-3">
            <label>Description:</label>
            <textarea wire:model="description" placeholder="Description.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800"></textarea>
            @error('description')
              <span class="text-red-500 xs">{{$message}}</span>
          @enderror
        </div>
        <div class="mt-3">
          <label>Status:</label>
          <select wire:model="status" placeholder="Project Status.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
            <option>Select Status</option>
            <option>Complete</option>
            <option>Active</option>
            <option>In Progress</option>
          </select>
          @error('status')
              <span class="text-red-500 xs">{{$message}}</span>
          @enderror
        </div>
        <div class="mt-3">
            <label>Deadline:</label>
            <input wire:model="deadline" type="date" placeholder="Project Name.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
            @error('deadline')
              <span class="text-red-500 xs">{{$message}}</span>
          @enderror
        </div>
        @if (Auth::user()->role!=="manager"&&Auth::user()->role !=="admin")
        <h1 class="text-red-500">Only admins and managers can create projects.</h1>
        
        
        @else
        <button type="submit" class="px-4 py-2 bg-blue-500 text white mt-4 rounded-xl hover:bg-blue-300 cursor-pointer">Create Project</button>
        @endif
    </form>
    <br>


  @if ($edit)
  
    @if (session('success'))
    <span class="text-green-500">{{ session('success') }}</span>
    
    @endif
  <form wire:submit.prevent="updateProject" wire:key="edit-project-{{ $edit }}">
    <div class="mt-3">
      <label>Project Name:</label>
      <input wire:model="editName" placeholder="Project Name.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
      @error('editName')
          <span class="text-red-500 xs">{{$message}}</span>
      @enderror
    </div>
    <div class="mt-3">
        <label>Description:</label>
        <textarea wire:model="editDescription" placeholder="Description.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800"></textarea>
        @error('editDescription')
          <span class="text-red-500 xs">{{$message}}</span>
      @enderror
    </div>
    <div class="mt-3">
      <label>Status:</label>
      <select wire:model="editStatus" placeholder="Project Status.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
        <option>Select Status</option>
        <option>Complete</option>
        <option>Active</option>
        <option>In Progress</option>
      </select>
      @error('editStatus')
          <span class="text-red-500 xs">{{$message}}</span>
      @enderror
    </div>
    <div class="mt-3">
        <label>Deadline:</label>
        <input wire:model="editDeadline" type="date" placeholder="Project Name.." class="px-10 py-2 bg-gray-100 border border-gray-500 rounded-xl text-gray-800">
        @error('editDeadline')
          <span class="text-red-500 xs">{{$message}}</span>
      @enderror
    </div>
    <button type="submit" class="px-4 py-2 bg-green-500 text white mt-4 rounded-xl hover:bg-green-300 cursor-pointer">Update</button>
    <button wire:click="cancelEdit" type="button" class="px-4 py-2 bg-red-500 text white mt-4 rounded-xl hover:bg-red-300 cursor-pointer">Cancel</button>
</form>
@endif
    
    <h1 class="text-2xl">Project List</h1>

    <div>
      <button wire:click="$set('viewTab','my')" class="py-2 px-4  text-white rounded-xl {{ $viewTab==='my' ? 'bg-green-500 underline' :'bg-gray-500'}}">My Projects</button>
      <button wire:click="$set('viewTab','team')" class="py-2 px-4  text-white rounded-xl {{ $viewTab==='team' ? 'bg-green-500 underline':'bg-gray-500' }}">Team Projects</button>
    </div>

    <table class="w-full border border-gray-200 rounded-2xl overflow-hidden">
        <thead>
            <tr class="text-gray-700 text-left">
                <th class="py-2 px-4 border-b">#</th>
                <th class="py-2 px-4 border-b">Project name</th>
                <th class="py-2 px-4 border-b">Project Description</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Deadline</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($projects as $project)
            <tr wire:key="{{ $project->id }}" class="text-gray-=700 text-left">
                <td class="py-2 px-4 border-b">{{$loop->iteration}}</td>
                <td class="py-2 px-4 border-b">
                  {{$project->name}}
                  @if ($project->user_id===Auth::id())
                  <span class="text-green-500">(Owner)</span>
                  @else
                  <span class="text-blue-500">(member)</span>
                  @endif
                </td>
                <td class="py-2 px-4 border-b">{{$project->description}}</td>
                <td class="py-2 px-4 border-b {{ $project->status==='Active' ? 'text-green-500':( $project->status==='In Progress' ? 'text-yellow-500' :'text-blue-500') }}">{{$project->status}}</td>
                <td class="py-2 px-4 border-b">{{$project->deadline}}</td>
                <td class="py-2 px-4 border-b">
                    <button wire:click="editProject({{ $project->id }})" class="bg-green-500 text-white px-2 py-1 rounded-xl hover:bg-green-300 cursor-pointer">Edit</button>
                    <button wire:click="deleteProject({{ $project->id }})" class="bg-red-500 text-white px-2 py-1 rounded-xl hover:bg-red-300 cursor-pointer">Delete</button>
                    <button wire:click="viewTasks({{ $project->id }})" class="bg-blue-500 px-2 py-1 rounded-xl text-white hover:bg-blue-300 cursor-pointer">Tasks</button>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center py-4 text-gray-500">No projects found</td>
        </tr>
        @endforelse
        </tbody>
    </table>
    {{$projects->links()}}
    
    
    <form class="mt-6 mb-6" wire:submit.prevent="AssignUsers" wire:key="assignUsers-form">
      <label>Select User</label>
    <select wire:model="selectedUser">
      <option>select User</option>
  @foreach ($users as $user)
  <option value="{{ $user->id}}">{{ $user->name }}</option>
      
  @endforeach
    </select>
    <label>Select project</label>
    <select wire:model="selectedProject">
      <option>Select project</option>
      
      @foreach ($projects as $project)
      <option value="{{ $project->id }}">{{ $project->name }}</option>
          
      @endforeach
    </select>
    <button type="submit" class="py-2 px-4 bg-yellow-500 text-white">Add Member</button>
  </form>
</div>
