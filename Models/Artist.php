<?php
namespace Members;

use \Studio\Productions\Music;
use \Studio\Band;

class Artist extends Member{
    public array $bands=[];
    public array $songs_liked=[];
    public int $followers;
    public string $age;

    function __construct(){

    }

    public static function params(string $name, string $bio, string $email, int $age, string $password , string $token = '', string $pfp = 'default.png'){
        $instance = new static();

        $instance->name = $name;
        $instance->bio = $bio;
        $instance->pfp = $pfp;
        $instance->age= $age;
        $instance->email = $email;
        $instance->password = $password;
        $instance->token = $token;
        $instance->followers = 0;

        $instance-> date_joined = date("Y-m-d H:i:s");
        $instance-> date_updated = date("Y-m-d H:i:s");

        if($instance->token == ''){
            $instance->generateToken();
        }

        return $instance;
    }
    public static function id(int $id){
        $instance = new static();

        $results = (new \Database\Query)->custom("SELECT 
            m.id, 
            m.name, 
            m.bio, 
            m.pfp, 
            m.email, 
            m.password, 
            m.token,
            a.age,
            a.followers,
            m.date_joined, 
            m.date_updated
            FROM members m 
            INNER JOIN artists a on a.id_member = m.id
            WHERE m.id = ?
        ", [$id]);

        foreach($results as $result){
            $instance->id = $result[0];
            $instance->name = $result[1];
            $instance->bio = $result[2];
            $instance->pfp = $result[3];
            $instance->email = $result[4];
            $instance->password = $result[5];
            $instance->token = $result[6];
            $instance->age = $result[7];
            $instance->followers = $result[8];
            $instance->date_joined = $result[9];
            $instance->date_updated = $result[10];


            foreach ((new \Database\Query)->read(["id_target"], "artist_followers", "id_member = ?", [$instance->id]) as $res) {
                
                $instance->following[] =  $res['id_target'];
            }

            foreach ((new \Database\Query)->read(["id_music"], "likes", "id_member = ?", [$instance->id]) as $res) {
                
                $instance->songs_liked[] =  $res['id_music'];
            }

        }

        return $instance;
    }

    public function follow($id){
        $params = [
            "id_member" => $id,
            "id_target" => $this->id
        ];
        (new \Database\Query)->create($params, "artist_followers");
    }

    public function unfollow($id){
        #delte function Queries
    }

    public function dislike($id){
        #delte function Queries
    }

    public function getBands(){

        $results = (new \Database\Query)->custom("SELECT b.id, b.name, b.image, b.num_songs, b.followers, b.date_created, b.date_updated 
        FROM artist_bands ab INNER JOIN band b on ab.id_bands = b.id
        INNER JOIN artists a on a.id = ab.id_artist WHERE ab.id_artist = ?", [$this->id]);

        foreach($results as $result){
            $result = [
                'id' => $result[0], 
                'name' => $result[1], 
                'image' => $result[2], 
                'num_songs' => $result[3], 
                'followers' => $result[4], 
                'date_created' => $result[5], 
                'date_updated' => $result[6] 
            ];
            $band = Band::params($result['name'], $result['image'], $result['num_songs'], $result['followers']);
            $band->id = $result['id'];
            $band->date_created = $result['date_created'];
            $band->date_updated = $result['date_updated'];

            $this->bands[] = $band;
        }

    }


    public function addMusic(Music $music) : void{
        if($this->id == 0){
            throw new Exception("User must be fetched first");
            exit();
        }
        if($music->getDateAdded() == ""){
            $music->setDateAdded(date("Y-m-d H:i:s"));
        }

        $music->authorId= $this->id;

        $music->add();
    }
    
    public function save() {

        $params = [
            "name" => $this->name, 
            "bio" => $this->bio, 
            "pfp" => $this->pfp,
            "email" => $this->email, 
            "password" => $this->password, 
            "token" => $this->token, 
            "date_joined" => $this->date_joined, 
            "date_updated" => $this->date_updated
        ];

        (new \Database\Query)->update($params, "members", "id = ?", [$this->id]);

        $params = [
            "followers" => $this->followers,
            "age" => $this->age
        ];

        (new \Database\Query)->update($params, "artists", "id_member = ?", [$this->id]);

    }

    public function add() {
        $params = [
            "name" => $this->name, 
            "bio" => $this->bio, 
            "pfp" => $this->pfp,
            "email" => $this->email, 
            "password" => $this->password, 
            "token" => $this->token, 
            "date_joined" => $this->date_joined, 
            "date_updated" => $this->date_updated
        ];

        (new \Database\Query)->create($params, "members");

        $results = (new \Database\Query)->custom("SELECT id FROM members ORDER BY id DESC LIMIT 1");
        $id=$results[0][0];

        $params = [
            "id_member" => $id,
            "followers" => $this->followers,
            "age" => $this->age
        ];

        (new \Database\Query)->create($params, "artists");
    }
}