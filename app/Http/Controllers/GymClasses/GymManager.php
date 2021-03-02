<?php 
namespace App\Http\Controllers\GymClasses;

use App\Models\UserGym;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Image;
use App\Models\Feedback;
use App\Http\Controllers\ProfileInformation;

class GymManager{

	private $GYM_ID;

    public function __construct(){
        $temp = ProfileInformation::getUser();
        if(isset($temp)){
            $this->GYM_ID = ProfileInformation::getUser()->id;
        }
    }

	//store gym data to database
	public function store($data){
		$gym = new UserGym;
		$gym->gym_id = $this->GYM_ID;
		$gym->gym_name = $data['gymname'];
		$gym->gym_phone = $data['gymphone'];
		$gym->gym_email = $data['gymemail'];
		$gym->gym_address = $data['address'];
		$gym->state = $data['state'];
		$gym->city = $data['city'];
		$gym->pincode = $data['pincode'];

		if(isset($data['gym_another_phone']))
			$gym->gym_phone_second = $data['gym_another_phone'];

		return $gym->save();

 	}

 	//image modification and save to destination location
 	private function imageModification($image){
		$fileName = uniqid() . time() . '.' . strtolower($image->getClientOriginalExtension());
		$location = storage_path('app/public/gym_docs/'.$fileName);
		$img = Image::make($image);

		if($img->width() < $img->height() && $img->height() >= 500){
			$img->resize(800, 1000);
		}
		else{
			$img->width() >= 800 || $img->height() >= 600 ? $img->resize(800, 600) : '';
		}

		$img->save($location);

		return $fileName;
 	}

 	//gym logo modification 
 	private function logoImageModification($image, $path){
 		if(!isset($image)){
 			return null;
 		}

 		$fileName = 'logo' . uniqid() . time() . '.' . strtolower($image->getClientOriginalExtension());
		$location = storage_path($path.$fileName);
		$img = Image::make($image);

		$img->resize(100, 100);

		$img->save($location);

		return $fileName;
 	}


 	//store gym data to database
	public function update($data){
		$gym = new UserGym;
		$result = $gym->where(['gym_id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1])->first();

		$result->gym_name = $data['gymname'];
		$result->gym_phone = $data['gymphone'];
		$result->gym_email = $data['gymemail'];
		$result->gym_address = $data['address'];
		if(!empty($data['gym_logo'])){
			$result->gym_logo = $this->logoImageModification($data['gym_logo'], 'app/public/gym_logo/');
		}

		$res = $result->update();
					 
		return $res;

 	}

 	//update user information
 	public function updateUserProfile($data){
 		$user = new User;
 		$result = $user->where(['id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1])->first();

 		$result->name = $data['name'];
 		$result->phone = $data['phone'];
 		$result->email = $data['email'];
 		if(!empty($data['profile_image'])){
 			$result->profile_image = $this->logoImageModification($data['profile_image'], 'app/public/user_image/');
 		}

 		$res = $result->update();
 		
 		return $res;
 	}

 	//update user profile password
 	public function updateUserProfilePassword($data){
 		if(Hash::check($data['old_password'], auth()->user()->password)){
 			$user = new User;
 			$result = $user->where(['id' => $this->GYM_ID, 'status' => 1, 'is_deleted' => 1])
 						   ->update(['password' => Hash::make($data['new_password'])]);

 			return $result;
 		}
 		else{
 			return -1;
 		}
 	}


 	//get gym existance alert
 	public function isAvailable(){
 		$gymData = $this->getMyGym();
 		if(!isset($gymData)){
 			return 0;
 		}
 		return 1;
 	}

 	//get personal gym data
 	public function getMyGym(){
 		$gym = new UserGym;
 		$gymData = $gym->where(['gym_id' => $this->GYM_ID, 'is_deleted' => 1, 'status' => 1])->first();
 		return $gymData; 
 	}

 	//get user profile data
 	public function getProfile(){
 		return auth()->user();
 	}


 	//sent feedback to squart from a gym
 	public function sentFeedback($data){
 		$gym = new Feedback;
 		$gym->title = $data['title'];
 		$gym->feedback = $data['feedback'];
 		return $gym->save();
 	}

 	//get gym information by gym owner or user id
 	// public function getGym($id){
 	// 	$user = User::find($id);
 	// 	$gym = $user->userGym;
 	// 	$gym->username = $user->username;

 	// 	return $gym;
 	// }

}
?>