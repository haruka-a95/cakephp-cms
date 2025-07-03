<?php
declare(strict_types=1);

namespace App\Model\Table;
use Cake\Validation\Validator;
use Cake\ORM\Table;
// Text クラス
use Cake\Utility\Text;
// EventInterface クラス
use Cake\Event\EventInterface;

class ArticlesTable extends Table //自動でarticlesテーブルを解釈
{
    public function initialize(array $config) : void
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('title', 'タイトルは必須です。')
            // ->minLength('title', 1)
            ->maxLength('title', 255)

            ->notEmptyString('body', '本文は必須です。');
            // ->minLength('body', 1);

            return $validator;
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->slug) {
            $sluggedTitle = Text::slug($entity->title);//titleでslug作成
            // スラグをスキーマで定義されている最大長に調整
            $entity->slug = substr($sluggedTitle, 0, 191);
        }
    }
}
