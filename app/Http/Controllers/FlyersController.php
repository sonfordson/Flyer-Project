<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\FlyerRequest;
use App\Http\Flash;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Flyer;
use Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FlyersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except'=>['show']]);

        if (in_array('__construct', get_class_methods(get_parent_class($this)))) {
            parent::__construct();
        }
    }
   public function index()
   {

   }

   public function create()
    {
       return view('flyers.create');
    }


    public function store(FlyerRequest $request)
    {
        $flyer = Auth::user()->publish(
            new Flyer($request->all())
             );
        flash()->overlay('Success!', 'Your flyer has been created.');
        dd($flyer);
        return redirect($flyer->zip .'/'. str_replace('','-',$flyer->street))->back();
    }

    public function show($zip, $street )
    {
        $flyer = Flyer::locatedAt($zip, $street);
        return view('flyers.show',compact('flyer'));

    }

    public function addPhoto($zip, $street, Request $request)
    {
        $this->validate($request,[
            'photo' => 'required|mimes:jpg,jpeg,png,bmp'
        ]);

         if(!$this->userCreatedFlyer($request))
        {
          return  $this->unauthorized($request);
        }

        $photo = $this->makePhoto($request->file('photo'));

        Flyer::locatedAt($zip, $street)->addPhoto($photo);

    }

    protected function unauthorized(Request $request)
    {
        if($request->ajax()){
            return response(['message'=>'No Way'], 403);
        }

        flash('No Way');

        return redirect('/');
    }

    protected function userCreatedFlyer(Request $request)
    {
        return Flyer::where([

            'zip'     => $request->zip,
            'street'  => $request->street,
            'user_id' => Auth::user()->id
        ])->exists();

    }

    protected  function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())->move($file);

    }

}
