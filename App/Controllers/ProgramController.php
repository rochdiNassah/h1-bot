<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response, Session};
use Automation\Framework\Filesystem\Filesystem;
use Automation\Framework\Facades\View;
use Automation\Framework\Facades\DB;
use Automation\Framework\Database\Database;
use GuzzleHttp\Client;

class ProgramController
{
    public function index(Database $db)
    {
        $stmt = $db->prepare('SELECT * FROM programs ORDER BY updated_at DESC');

        $stmt->execute();

        $programs = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return View::make('program.all', ['programs' => $programs]);
    }

    public function delete(int $id, Database $db, Request $request, Session $session)
    {
        $request->input('id', $id)->exists('programs', 'id');

        $request->validate();

        $stmt = $db->prepare('DELETE FROM programs WHERE id = ?');

        $stmt->execute([$id]);

        $session->set('message', 'Program deleted!');

        return $request->back();
    }

    public function add(Request $request, Response $response, Client $client, Filesystem $fs)
    {
        $handle = $request->input('handle')->required()->missingFrom('programs', 'handle')->strtolower();

        $request->validate();

        $json_request = json_decode(file_get_contents($fs->to('resources/json/requests/hackerone/assets.json')));

        $json_request->variables->handle = (string) $handle;

        $response = json_decode((string) $client->request('POST', 'https://hackerone.com/graphql', ['json' => $json_request])->getBody());

        $assets = [];

        foreach ($response->data->team->in_scope_assets->edges as $asset) {
            array_push($assets, $asset->node->asset_identifier);
        }

        $stmt = DB::prepare('INSERT INTO programs(handle, assets, created_at) VALUES(?, ?, ?)');

        $result = $stmt->execute([$handle, json_encode($assets), time()]);

        if (!$result) {
            $request->addError('', 'Something went wrong!');
        
            return $request->back();
        }

        $request->addMessage('', 'Program added!');

        return View::make('homepage');
    }
}
