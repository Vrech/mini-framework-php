<?php
    $this->get('noticias', function($arg){
        
        // Abre o módulo template
        $tpl = $this->core->loadModule('template');
        
        // Abre o módulo/"model" de notícias
        $news = $this->core->loadModule('news');

        // Enviando dados para o template
        $array = array();
        $array['news'] = $news->getNewsList();

        // Carregando o template
        $tpl->render('exemplo', $array);
    });

    $this->get('noticias/{id}', function($arg){
        $tpl = $this->core->loadModule('template');
        $news = $this->core->loadModule('news');

        $array = array();
        $array['info'] = $news->getNewsInfo($arg['id']);

        $tpl->render('noticias_item', $array);
    });

    $this->post('noticias', function($arg){
        echo "Método POST.";
    })
?>