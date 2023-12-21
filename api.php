<?php

// This is a suite of functions to retrieve
// resources from themoviedb.org based on
// ID values that are stored in the "Movies" table



function get_movie_info($movie_id) {

    $api_key = "6965869d99871a574ab231eb262e0e76";

    $url = "https://api.themoviedb.org/3/movie/$movie_id?api_key=$api_key&append_to_response=videos,images";

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPGET, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $json_associative = json_decode($response, true);

    return $json_associative;
}


function embed_trailer($movie_id) {

    $data = get_movie_info($movie_id);

    // in $data['videos']['results'][#] look for
    // a name value that includes "official" or "trailer"
    // if that name is found, use that ID
    // else, use the ID for the first of all videos

    $video_id = "";

    foreach ($data['videos']['results'] as $video_data) {
        if (str_contains(strtolower($video_data['name']), "official") ||
            str_contains(strtolower($video_data['name']), "trailer")) {
            $video_id = $video_data['key'];
            break; // end search after "hit"
        }
    }

    // if no "official" trailer found, default to first video in array
    if ($video_id == "") {
        $video_id = $data['videos']['results'][0]['key'];
    }

    echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/$video_id' frameborder='0' allowfullscreen></iframe>";
}


function get_poster_path($movie_id) {

    $data = get_movie_info($movie_id);
    $image_id = $data['poster_path'];

    return "https://image.tmdb.org/t/p/w500/$image_id";
}


function embed_poster($movie_id) {
    echo "<img src=" . get_poster_path($movie_id) . ">";
}


function get_user_subscriptions($user_id) {

    $query = "SELECT movie_id FROM Subscriptions WHERE user_id = $user_id";
    $statement = dbConnect()->prepare($query);
    $statement->execute();

    // create an array of all movie IDs
    $subscriptions = [];
    foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $datum) {
      array_push($subscriptions, $datum['movie_id']);
    }

    return $subscriptions;
}
