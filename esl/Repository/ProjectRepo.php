<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 4/22/18
 * Time: 2:33 PM
 */

namespace Esl\Repository;


use App\Mail\ProjectInvoice;
use App\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProjectRepo
{

    protected $projectName;
    public static function init()
    {
        return new self;
    }

    public function generateName($name)
    {
        $this->projectName = $this->checkIfProjectExist($name);
        return $this;
    }

    private function checkIfProjectExist($name)
    {
        $numberOftime = count(Project::where('ProjectName',$name)->get()) + 1;
        $currentYear = Carbon::now()->format('y');
        return strtoupper($name.'/'.$numberOftime.'/'.$currentYear);
    }

    public function getProjectNumber($id)
    {
        return Project::where('ProjectLink',$id)->get()->first()->ProjectName;
    }

    public function makeProject()
    {
        Mail::to(['email'=>'accounts@esl-eastafrica.com'])
            ->cc(['evans@esl-eastafrica.com','accounts@freightwell.com','accounts@sovereignlog.com'])
            ->send(new ProjectInvoice(['message'=>'Project '.$this->projectName.
                ' has been created by '. ucwords(Auth::user()->name) . ' on '.Carbon::now()->format('d-M-y H:m'). '. Kindly prepare in advance '],'PROJECT '. $this->projectName . ' CREATED'));

        return Project::insertGetId([
            'ProjectName' => $this->projectName,
            'ProjectCode' => $this->projectName,
            'ActiveProject' => 1,
            'MasterSubProject' => $this->projectName,
            'ProjectDescription' => $this->projectName,
            'ProjectLevel' => 0,
//            'Project_iChangeSetID' =>,
//            'Project_iCreatedAgentID',
//            'Project_iCreatedBranchID',
//            'Project_iModifiedAgentID',
//            'Project_iModifiedBranchID',
            'SubProjectOfLink' => 0,
//            'Project_Checksum' => ,
            'Project_dCreatedDate' => Carbon::now(),
//            'Project_dModifiedDate' => null,
            'Project_iBranchID' => 0
            ]
        );
    }
}