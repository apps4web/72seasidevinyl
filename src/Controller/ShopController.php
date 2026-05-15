<?php
declare(strict_types=1);

namespace App\Controller;

class ShopController extends AppController
{
    public function index()
    {
        $q      = trim((string)$this->request->getQuery('q', ''));
        $artist = trim((string)$this->request->getQuery('artist', ''));
        $genre  = trim((string)$this->request->getQuery('genre', ''));

        $recordsTable = $this->fetchTable('Records');

        $query = $recordsTable
            ->find()
            ->contain(['Artists', 'Genres'])
            ->orderBy(['Records.created' => 'DESC']);

        if ($artist !== '') {
            $query->matching('Artists', fn($q) => $q->where(['Artists.name' => $artist]));
        }

        if ($genre !== '') {
            $query->matching('Genres', fn($q) => $q->where(['Genres.name' => $genre]));
        }

        if ($q !== '') {
            $artistIds = $this->fetchTable('Artists')
                ->find()
                ->select(['id'])
                ->where(['name LIKE' => '%' . $q . '%'])
                ->all()
                ->extract('id')
                ->toList();

            $query->where(function ($exp) use ($q, $artistIds) {
                $conditions = [$exp->like('Records.name', '%' . $q . '%')];
                if (!empty($artistIds)) {
                    $conditions[] = $exp->in('Records.artist_id', $artistIds);
                }
                return $exp->or($conditions);
            });
        }

        $this->paginate = ['limit' => 24];
        $records = $this->paginate($query->distinct(['Records.id']));

        $this->set(compact('records', 'q', 'artist', 'genre'));
    }

    public function record($id = null)
    {
        $record = $this->fetchTable('Records')->get($id, contain: [
            'Artists',
            'Genres',
            'Tracks',
            'RecordImages',
            'RecordsArtists.Companies',
        ]);

        $this->set('record', $record);
        $this->set('title', h($record->artist->name) . ' – ' . h($record->name));
    }
}
