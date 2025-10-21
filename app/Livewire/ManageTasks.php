<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTasks extends Component
{
    use WithPagination;
    public $projectId;

    #[Rule('required')]
    public $title;

    #[Rule('required')]
    public $duedate;

    public $search;

    public function createTask(){
        $validated= $this->validate();
        $validated['project_id']=$this->projectId;
        $tasks=Task::create($validated);
        $this->reset(['title','duedate']);

        $this->resetPage();
        session()->flash('success','Task added successfully');
        
    }

    public function deleteTask(Task $task){
          $task->delete();
    }


    public function toggle($taskId){

        $task=Task::findOrFail($taskId);
        $task->status=!$task->status;
        $task->save();

    }

    public function render()
    {
        $latestId=Task::max('id');
        $tasks= Task::query()->where('project_id', $this->projectId)->when($this->search,function($query){
            $query->where('title','like',"%{$this->search}%");
        })
        ->latest()
        ->paginate(2);
        $this->resetPage();
        //$tasks=Task::where('project_id',$this->projectId)->orWhere('title','like',"%{$this->search}%")->latest()->paginate(2);
        return view('livewire.manage-tasks',compact('tasks','latestId'));
    }
}
