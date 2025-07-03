<h1>記事の追加</h1>
<?php
    echo $this->Form->create($article);
    // 今はユーザーを直接記述
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('title', [
        'label' => 'タイトル',
        'placeholder' => '記事のタイトルを入力してください',
        'required' => true
    ]);
    echo $this->Form->control('body', [
        'label' => '本文',
        'placeholder' => '本文を入力してください',
        'rows' => '3'
    ]);
    echo $this->Form->button(__('記事を追加'));
    echo $this->Form->end();
?>