<?php

namespace App\Observers;

use App\Mail\ProjectUpdate;
use App\Models\Project;
use App\Models\RecipientGroup;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $group = RecipientGroup::where('field', "Item created")
            ->where('value', 'CoC')
            ->first();

        if (! empty($group)) {
            $group->mail('New CoC Ticket Created', 'emails.project.created', $project);
        }
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        if ($project->isDirty('status')) {
            $group = RecipientGroup::where('field', "Status")
                ->where('value', $project->status)
                ->first();

            if (! empty($group)) {
                $group->mail('Status Change on CoC Ticket', 'emails.project.status', $project);
            }
        }

        if ($project->isDirty('currently_responsible')) {
            $group = RecipientGroup::where('field', "Currently responsible")
                ->where('value', $project->currently_responsible)
                ->first();

            if (! empty($group)) {
                $group->mail('New CoC Ticket', 'emails.project.assigned-department', $project);
            }

            $individual = User::where('name', $project->currently_responsible)->first();

            if (! empty($individual)) {
                Mail::to($individual->email)->send(new ProjectUpdate('New CoC Ticket', 'emails.project.assigned-individual', $project));
            }
        }
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}