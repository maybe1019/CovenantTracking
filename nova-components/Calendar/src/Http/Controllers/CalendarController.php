<?php

namespace Acme\Calendar\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Storage;
//use Illuminate\Http\UploadedFile;

class CalendarController extends Controller
{
    //

    public function fetchData(Request $request)
    {

        $tracking_data = DB::select("
            SELECT
                compliances_covenant_instances.id, compliances_covenant_instances.covenantId, compliances_covenant_instances.`status`, compliances_covenant_instances.activateDate as trackingDate,
                compliances_covenants.complianceId, compliances_covenants.type, compliances_covenants.subType,
                compliances.clcode, compliances.docName, compliances.startDate, compliances.endDate 
            FROM
                compliances_covenant_instances
                LEFT JOIN compliances_covenants ON compliances_covenant_instances.covenantId = compliances_covenants.id
                LEFT JOIN compliances ON compliances_covenants.complianceId = compliances.id
        ");

        echo json_encode($tracking_data);
        die;
    }

    public function submitResult(Request $request) {
        $status = $request->status;
        $resolution = $request->resolution;
        $comments = $request->comments;
        $instanceId = $request->instanceId;
        $covenantId = $request->covenantId;
        $resolutionStatus = $request->resolutionStatus;

        $fileUris = array();

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                
                $name = time() . $file->getClientOriginalName();
                $path = Storage::disk('s3')->put($name, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);

                array_push($fileUris, $path);
            }
        }

        $today = date("Y-m-d");

        DB::table('compliances_covenants_tracking')
            ->insert([
                'resolutionValue' => $resolution,
                "uploads"=> json_encode($fileUris),
                'comments'=>$comments,
                'resolutionStatus' => $resolutionStatus,
                'instanceId' => $instanceId,
                'covenantId' => $covenantId,
                'trackingDate' => $today,
                'status' => $status
            ]);

        return response()->json(['result'=>'success']);

        die;
    }

    public function fetchCovenant(Request $request)
    {
        $standard_covenants = DB::table('standard_covenants')
            ->select('type')
            ->groupBy('type')
            ->get();

        $covenant_data = [];
        $i = 0;
        foreach ($standard_covenants as $covenant) {
            $covenant_data[$i]['type'] = $covenant->type;
            $i++;
        }

        echo json_encode($covenant_data);
        die;
    }
}
