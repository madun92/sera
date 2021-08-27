<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;
use Kreait\Laravel\Firebase\Facades\FirebaseAuth;
use Kreait\Laravel\Firebase\Facades\FirebaseDatabase;

class FirebaseProjectController extends Controller
{

    public function index()
    {
        $data = FirebaseDatabase::getReference('projects')->getValue() ?? [];
        return $this->responseJson(false, $data);
    }

    public function store(Request $request, Database $db)
    {
        $payload = $this->validate($request, [
            "title" => "required",
            "description" => "required",
        ]);
        // Create a key for a new post
        $newPostKey = $db->getReference('projects')->push()->getKey();
        $uid = auth()->user()->id;
        $payload["user_id"] = $uid;
        $updates = [
            'projects/'.$newPostKey => $payload,
            // 'user-projects/'.$uid.'/'.$newPostKey => $payload,
        ];
        $db->getReference() // this is the root reference
             ->update($updates);
        return $this->responseJson(false, $updates);
    }

    public function show(Database $db, $id)
    {
        $post = $db->getReference("projects/$id")->getValue();
        if (!$post) {
            abort(404);
        }
        return $this->responseJson(false, $post /*+["id" => $request->id]*/, "Show a project.");
    }

    public function update(Request $request, Database $db)
    {
        $payload = $this->validate($request, [
            "id" => "required",
            "title" => "sometimes",
            "description" => "sometimes",
        ]);
        $post = $db->getReference("projects/$request->id")->update($request->only(["title","description"] + ["merge" => true]));
        return $this->responseJson(false, $post->getValue() /*+["id" => $request->id]*/, "update firebase project successfully!");
    }

    public function destroy(Request $request, Database $db)
    {
        $payload = $this->validate($request, [
            "id" => "required",
        ]);
        $post = $db->getReference("projects/$request->id")->set(null);
        return $this->responseJson(false, $post->getValue() ?? [] , "Delete firebase project successfully!");
    }
}
