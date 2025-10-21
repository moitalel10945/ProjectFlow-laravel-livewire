<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ManageProjects extends Component
{
    
    #[Rule('required|min:4')]
    public $name;
    #[Rule('required|min:5')]
    public $description;
    #[Rule('required')]
    public $status;
    #[Rule('required')]
    public $deadline;

    
    public $edit;
    public $editName;
    public $editDescription;
    public $editStatus;
    public $editDeadline;

    public $selectedUser;
    public $selectedProject;
    public $viewTab='my';


    use WithPagination;
    public function createProject(){
        $validated=$this->validate();
        $role=Auth::user()->role;

        if($role !=='manager' && $role !=="admin"){
            abort(403,"Only admins and managers are authorised to create projects");
        }
        
        $projects=Auth::user()->projects()->create($validated);

        session()->flash('success','Project Added Successfully');
        $this->resetPage();
        $this->reset(['name', 'description', 'status', 'deadline']);

        
        

        
    }
    public function deleteProject(Project $project){
        $role=Auth::user()->role;
        if($role !== 'admin'&& $role  !=='manager'){
            abort(403,'This task is only Authrized for admins and managers');
        }
        $project->delete();
        $this->resetPage();
    }

    public function editProject($id){
        $project=Project::findOrFail($id);
        $this->edit=$project->id;
        $this->editName=$project->name;
        $this->editDescription=$project->description;
        $this->editStatus=$project->status;
        $this->editDeadline=$project->deadline;

    }

    public function updateProject(){
        $role=Auth::user()->role;
        if($role !== 'admin'&& $role  !=='manager'){
            abort(403,'This task is only Authrized for admins and managers');
        }
        $this->validate([
            'editName'=>'required|min:4',
            'editDescription'=>'required|min:5',
            'editStatus'=>'required',
            'editDeadline'=>'required'

        ]);
        $project=Project::findOrFail($this->edit);
        $project->update([
            'name'=>$this->editName,
            'description'=>$this->editDescription,
            'status'=>$this->editStatus,
            'deadline'=>$this->editDeadline
        ]);
        session()->flash('success',"Congratulations, youve edited project {$project->name} successfully");
        $this->reset(['editName','editDescription','editStatus','editDeadline','edit']);
    }
    public function cancelEdit(){
        $this->reset(['edit','editName','editDescription','editStatus','editDeadline']);
    }

    public function viewTasks($projectId){
        return redirect()->route('projects.tasks',$projectId);
    }

    public function AssignUsers(){
        $role=Auth::user()->role;
        if($role !=='manager' && $role !=='admin'){
            abort(403, 'Only Admins and Managers can assign members to projects');
        }
        $project=Project::findOrFail($this->selectedProject);
        $project->members()->syncWithoutDetaching([$this->selectedUser]);
        session()->flash('success','member assigned successfully');

    }
    public function render()
    {
       // $projects=Auth::user()->projects()->latest()->paginate(4);
        $users=User::all();
        $user=Auth::user();

        if($this->viewTab==='my'){
            $projects=Project::where('user_id',$user->id)->latest()->paginate(5);
        }
        else{
            $projects=Project::whereHas('members',function($query) use($user){
                $query->where('user_id',$user->id);
            })->latest()->paginate(5);
        }

        /*$projects=Project::where('user_id',$user->id)->orWhereHas('members',function($query) use ($user){
            $query->where('user_id', $user->id);
        })
        ->latest()->paginate(2);*/
       
        return view('livewire.manage-projects',compact('projects','users'));
    }
}
