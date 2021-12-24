<?php

namespace App\Controllers;


use App\{Core\Database\QueryBuilder,
    Core\Helpers\Redirect,
    Core\Request\Request,
    Core\Response\Response,
    Core\Session\Session,
    Core\View\View
};

class EventController extends Controller
{
    public function create()
    {
        if (!Session::get('user')) {
            return $this->response("unauthenticated", 401);
        }

        $this->request->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required'
        ]);

        if ($this->request->isValid()) {
            $params = array_merge($this->request->all(), ['user_id' => Session::get('user')->id]);
            $this->db->insert('events', $params)->execute();
            return $this->response('Event Created');
        }

        return $this->response(json_encode($this->request->getMessages()), 400);
    }

    public function update()
    {
        if (!Session::get('user')) {
            return $this->response("unauthenticated", 401);
        }
        $this->request->validate([
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required'
        ]);

        if ($this->request->isValid()) {
            $request = $this->request->getParams();

            $this->db->update('events', [
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date
            ])
                ->where('id', '=', $request->event_id)
                ->execute();
            return $this->response('Event Updated');
        }

        return $this->response(json_encode($this->request->getMessages()), 400);

    }


    public function delete()
    {
        $validation = $this->request->validate([
            'id' => 'required|exists:events'
        ]);

        if (!$validation->isValid()) {
            return $this->response(json_encode($validation->getMessages()), 400);
        }
        $deleted = $this->db->delete('events')->where('id', '=', $this->request->getParams()->id)->execute();
        var_dump($deleted);
    }
}