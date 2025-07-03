<?php
namespace App\Controller;
use Cake\Controller\Component\FlashComponent;

class ArticlesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function index()
    {
        $articles = $this->paginate($this->Articles);
        $this->set(compact('articles'));
    }

    public function view($slug = null)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();//与えられたスラグによって記事を検索する基本的なクエリーを 作成する。テーブルにslugカラムがあればその値がslugになる。
        $this->set(compact('article'));
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            $article->user_id = 1;

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('記事が保存されました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('記事を追加できませんでした。'));
        }
        $this->set('article', $article);
    }

    public function edit($slug)
    {
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('記事が更新されました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('記事を更新できませんでした。'));
        }
        $this->set('article', $article);
    }

    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);

        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('記事{0}が削除されました。', $article->title));

            return $this->redirect(['action' => 'index']);
        }
    }
}