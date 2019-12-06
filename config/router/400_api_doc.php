<?php

/**
* Play the game.
 */
$app->router->get("api", function () use ($app) {
    $title = "API dokumentation";

    $app->page->add("api/default");

    return $app->page->render([
        "title" => $title,
    ]);
});
