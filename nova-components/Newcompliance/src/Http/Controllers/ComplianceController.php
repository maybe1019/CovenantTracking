<?php

namespace Axis\Newcompliance\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Axis\Newcompliance\Models\Compliancetool;
use Storage; 
//use Illuminate\Http\UploadedFile;

class ComplianceController extends Controller
{
    //

    public function save(Request $request) 
    {
    	$current_user = \Auth::user()->id;
    	$docnames= [];
    	foreach($request->files as $file)
        {
        	foreach($file as $upload)
        	{

	           	$name= time().'_'.$upload->getClientOriginalName();
	            $filePath = '/' . $name;
	            $docnames[] = $name;
	            $path = Storage::disk('s3')->put('/'.$name, $upload);
	            if (!Storage::disk('s3')->exists($name)) {    			
					//$url = Storage::disk('s3')->url('1656308436_logo.jpg');
					return response()->json('Error uploading file '.$name.' Compliance could not be created.');
				}
        	}
        }

        $docnames_json = json_encode($docnames);
    	$compliancetool = new Compliancetool([
            'clcode' => $request->clcode,
            'isin' => $request->isin,
            'docName' => $request->docName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'priority' => $request->priority,
            'secured' => $request->secured,
            'inconsistencyTreatment' => $request->inconsistencyTreatment,
            'clientReference' => $request->clientReference,
            'mailCC' => $request->mailCC,
            'documentNames' => $docnames_json,
            'userId' => $current_user,
        ]);
        $compliancetool->save();

        echo json_encode('success');die;
    }

    public function fetchClients(Request $request) 
    {
    	$current_user = \Auth::user()->id;
    	$org_id = DB::table('users')->where('id', $current_user)->value('organization_id');
    	$clients = DB::table('clients')->get()->where('organization_id', $org_id);
    	$client_data = [];
    	$i = 0;
    	foreach ($clients as $client) {
        	$client_data[$i]['id'] = $client->id;
        	$client_data[$i]['name'] = $client->name;
        	$i++;
    	}
    	echo json_encode($client_data); die;

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

        echo json_encode($covenant_data); die;

    }

    public function fetchSubtypes(Request $request) 
    {
        $covenant_details = [];
        if($request->input('type') !== null) 
        {
            $type = $request->input('type');
            $standard_covenants = DB::table('standard_covenants')
                ->where('type',$type)
                ->get();
            
            $i = 0;
            foreach ($standard_covenants as $covenant) {
                $covenant_details[$i]['id'] = $covenant->id;
                $covenant_details[$i]['subType'] = $covenant->sub_type;
                $covenant_details[$i]['description'] = $covenant->description;
                if($covenant->covenant_parameters != null)
                    $covenant_details[$i]['covenantParameters'] = json_decode($covenant->covenant_parameters, true);
                $i++;
            }
        }
        echo json_encode($covenant_details); die;
    }
}