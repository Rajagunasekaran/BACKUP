<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exercise extends Controller_Website {

	public function _construct() {
         parent::__construct($request, $response);
    } 
		
	public function action_index()
	{
		$this->template->title = 'Exercise Dashboard';
		$this->render();
	}
	public function action_workoutplans()
	{
		$this->template->title = 'Exercise Workout Plans';
		$this->render();
	}
	public function action_myworkout()
	{
		$parentFolderId		   = urldecode($this->request->param('id'));
		$workoutModel 		   = ORM::factory('workouts');
		$parentFolderArray     = array();
		if (HTTP_Request::POST == $this->request->method()){
			$method = $this->request->post('f_method');
			$datevalue = date('Y-m-d H:i:s');
			if(!empty($method) && trim($method) == 'addfolder'){
				$inputArray['folder_title'] 	= $this->request->post('folder_name');
				$inputArray['created_by']  = $inputArray['user_id']  	= $this->globaluser->pk();
				$inputArray['parent_folder_id'] = $this->request->post('f_foldid');
				$inputArray['created_date'] 	= $datevalue;
				$inputArray['modified_date']	= $datevalue;
				$workoutModel->insertFolderDetails($inputArray);
				$this->session->set('success','Successfully <b>'.$inputArray['folder_title'].'</b> Folder was added!!!');
			}elseif(!empty($method) && trim($method) == 'editfolder'){
				$inputArray['folder_title'] 	= $this->request->post('folder_name');
				$inputArray['parent_folder_id'] = $this->request->post('f_foldid');
				$inputArray['modified_by']  	= $inputArray['user_id']  	= $this->globaluser->pk();
				$inputArray['modified_date']	= $datevalue;
				$workoutModel->updateFolderDetails($inputArray,$this->request->post('f_id'));
				$this->session->set('success','Successfully <b>'.$inputArray['folder_title'].'</b> Folder was updated!!!');
			}elseif(!empty($method)){
				$workouts  = $this->request->post('workouts');
				$folders   = $this->request->post('folders');
				if(is_array($workouts) && count($workouts) > 0){
					foreach($workouts as $keys => $values){
						if(trim($method) == 'copy')
							$workoutModel->doCopyForWorkoutFolderById('workout', $this->globaluser->pk(),  $values, $this->request->post('parent_folder_id'));
						elseif(trim($method) == 'delete')
							$workoutModel->doDeleteForWorkoutFolderById('workout', $this->globaluser->pk(), $values, $this->request->post('parent_folder_id'));
					}
				}
				if(is_array($folders) && count($folders) > 0){
					foreach($folders as $keys => $values){
						if(trim($method) == 'copy')
							$workoutModel->doCopyForWorkoutFolderById('folder', $this->globaluser->pk(), $values, $this->request->post('parent_folder_id'));
						elseif(trim($method) == 'delete')
							$workoutModel->doDeleteForWorkoutFolderById('folder', $this->globaluser->pk(), $values, $this->request->post('parent_folder_id'));
					}
				}
				if($method == 'copy')
					$this->session->set('success','Successfully copied!!!');
				else
					$this->session->set('success','Successfully deleted!!!');
			}
			$this->redirect('exercise/myworkout');
		}
		if(!empty($parentFolderId) && is_numeric($parentFolderId)){
			$title 				= 'My workout plans folder';
			$parentFolderArray 	= $workoutModel->getFolderDetailsByUser($this->globaluser->pk(), $parentFolderId);
			$myworkoutDetails   = $workoutModel->getWorkoutDetailsByUser($this->globaluser->pk(), $parentFolderId);
		}else{
			$title 				= 'My workout plans';
			$myworkoutDetails 	= $workoutModel->getWorkoutDetailsByUser($this->globaluser->pk());
		}
		$myworkouts = array();
		if(isset($myworkoutDetails) && count($myworkoutDetails)>0){
			foreach($myworkoutDetails as $keys => $values){
				$myworkouts[$keys]				= $values;
			}
		}
		$this->template->title 					 =	$title;
		$this->render();
		
		$this->template->content->myworkouts	 = $myworkouts;
		$this->template->content->parentFolder   = $parentFolderArray;
		$this->template->content->parentFolderId = (!empty($parentFolderId) ? $parentFolderId : 0);
	}
	
	public function action_sampleworkout()
	{
		$parentFolderId		   = urldecode($this->request->param('id'));
		$workoutModel 		   = ORM::factory('workouts');
		$parentFolderArray     = array();
		if (HTTP_Request::POST == $this->request->method()){
			$method = $this->request->post('f_method');
			$datevalue = date('Y-m-d H:i:s');
			if(!empty($method)){
				$postbuttonArr   = explode('_',$method);
				$recordId		 = $postbuttonArr[2];
				if(!empty($recordId)){
					if(trim($method) == 'copy_workout_'.$recordId)
						$workoutModel->doSampleCopyForWorkoutFolderById('workout', $this->globaluser->pk(),  $recordId, $this->request->post('parent_folder_id'));
					elseif(trim($method) == 'copy_folder_'.$recordId)
						$workoutModel->doSampleCopyForWorkoutFolderById('folder', $this->globaluser->pk(), $recordId, $this->request->post('parent_folder_id'));
					$this->session->set('success','Successfully copied!!!');
				}
			}
			$this->redirect('exercise/myworkout');
		}
		if(!empty($parentFolderId) && is_numeric($parentFolderId)){
			$title 				= 'Sample workout plans folder';
			$parentFolderArray 	= $workoutModel->getFolderDetailsByUser($this->globaluser->pk(), $parentFolderId);
			$myworkouts   		= $workoutModel->getWorkoutDetailsByUser($this->globaluser->pk(), $parentFolderId);
		}else{
			$title 			= 'Sample workout plans';
			$myworkouts 	= $workoutModel->getSampleWorkoutDetails();
		}
		$this->template->title 					 =	$title;
		$this->render();
		
		$this->template->content->myworkouts	 = $myworkouts;
		$this->template->content->parentFolder   = $parentFolderArray;
		$this->template->content->parentFolderId = (!empty($parentFolderId) ? $parentFolderId : 0);
	}
	
	public function action_workoutrecord()
	{
		$this->template->title = 'Exercise Record';
		$workoutModel 		   = ORM::factory('workouts');
		$workid 			   = urldecode($this->request->param('id'));
		$exerciseid			   = urldecode($this->request->param('eid'));
		$this->render();
		if (HTTP_Request::POST == $this->request->method()){
			$this->session->set('success','Exercise set updated Successfully!!!');
			$this->redirect('exercise/workoutrecord/'.$workid);
		}
		if(!empty($workid) && is_numeric($workid))
			$this->template->content->workoutRecord = $workoutModel->getworkoutById(0,$workid);//$this->globaluser->pk()
			
		if(empty($exerciseid)){
			$this->template->content->focusRecord 	= $workoutModel->getAllFocus();
			$this->template->content->exerciseRecord= $workoutModel->getExerciseSet($workid);
		}elseif(!empty($workid) && is_numeric($workid) && !empty($exerciseid) && is_numeric($exerciseid)){
			$this->template->content->exerciseSet= $workoutModel->getExerciseSetDetailsByWorkout($workid,$exerciseid);
		}else
			$this->redirect('exercise/myworkout');
		$this->template->content->exerciseSetId     = trim($exerciseid);
		$this->template->content->workoutId		    = trim($workid);
	}
	public function action_workoutfolder()
	{
		$this->template->title = 'Exercise folder workouts';
		$workoutModel 		   = ORM::factory('workouts');
		$getFolderid		   = urldecode($this->request->param('id'));
		if(!empty($getFolderid) && is_numeric($getFolderid)){
			$folderWorkouts    = $workoutModel->getWorkoutDetailsByUser($this->globaluser->pk(), $getFolderid);
		}else{
			$this->redirect('exercise/myworkout');
		}
		$this->render($this->template, 'pages/exercise/myworkout');
		$this->template->content->myworkouts = $folderWorkouts;
		$this->template->content->folderlevel = $getFolderid;
	}
	public function action_exerciseset()
	{
		$this->template->title = 'Exercise Set';
		$workoutModel 		   = ORM::factory('workouts');
		$exerciseid			   = urldecode($this->request->param('id'));
		$this->render();
		if(!empty($exerciseid) && is_numeric($exerciseid)){
			$this->template->content->exerciseSet   = $workoutModel->getExerciseById($exerciseid);//$this->globaluser->pk()
			//$this->template->content->focusRecord 	= $workoutModel->getAllFocus();
			//$this->template->content->exerciseRecord= $workoutModel->getExerciseSet($workid);
		}
	}
	public function action_exerciselibrary()
	{
		$this->template->title = 'Exercise Library';
		$workoutModel = ORM::factory('workouts');
		$this->render();
		$this->template->content->exerciseType		= $workoutModel->getunitsbytable('unit_type');
		$this->template->content->exerciseStatus	= $workoutModel->getunitsbytable('unit_status');
		$this->template->content->exerciseAccess	= $workoutModel->getunitsbytable('unit_access');
	}
	public function action_exerciserecordlist()
	{
		$this->template->title = 'Exercise Record List';
		$workoutModel = ORM::factory('workouts');
		$this->render();
	}
	public function action_exerciserecord()
	{
		$this->template->title = 'Exercise Record';
		$workoutModel = ORM::factory('workouts');
		$this->render();
	}
	public function action_myactionplan()
	{
		$this->template->title = 'My Action Plans';
		$workoutModel = ORM::factory('workouts');
		$this->render();
		$this->template->content->wkoutAssignRecords  = $workoutModel->getAssignedWorkouts($this->globaluser->pk(), date("Y-m-d"));
	}
	public function action_myactioncalendar()
	{
		$this->template->title = 'My Action Calendar';
		$workoutModel = ORM::factory('workouts');
		$getdate      = '';
		if (strtotime(trim($_GET['getdate']))){
			$getdate = trim($_GET['getdate']);
		}else{
			$this->redirect('exercise/myactionplan');
		}
		$this->render();
		$this->template->content->getdate      = $getdate;
		//$this->template->content->wkoutAssign  = $workoutModel->getAssignedWorkouts($getdate, $this->globaluser->pk());
	}
	public function action_filemanager()
	{
		$this->template->title = 'File manager';
		$this->render();
	}
	public function action_upload(){
		$directory = DOCROOT.'assets/uploads/fileupload/';
		$data = $_POST['imgData'];
		$filename=$_POST['imgName'];
		$imgname=$filename.'_'.date("dmyhis").'.png';
		$file = $directory.$imgname;
		$data = substr($data,strpos($data,",")+1);
		$data = base64_decode($data);
		if(file_put_contents($file, $data)){
			$flag = 1;
		}
		else{
			$flag = 0;
		}
		$values=array($flag,$imgname);
		echo json_encode($values);
		die();
	}
	public function action_upload_img(){
		if ($this->request->method() == Request::POST)
        {
            if (isset($_FILES['file']))
            {
                $filename = $this->_save_image($_FILES['file']);
            }
        }
	}
	protected function _save_image($image)
    {
		$directory = DOCROOT.'assets/uploads/fileupload/';
        if (
            ! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
        {
            return FALSE;
        }
		chmod($directory,0777);
        if ($file = Upload::save($image, NULL, $directory))
        {
            $filename = $_FILES['file']['name'];
 
            Image::factory($file)
                // ->resize(200, 200, Image::AUTO)
                ->save($directory.$filename);
 
            // Delete the temporary file
            unlink($file);
 
            return $filename;
        } 	
        return FALSE;
    }
} // End Welcome
