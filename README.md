# Mini-Framework PHP

Este é um mini-framework feito em PHP. A finalidade dele é apenas para estudos, por isso tamanha simplicidade. 

Nesse exemplo, iremos utilizar um sistema de notícias simples, onde será possível listar todas as notícias cadastradas no banco e também iremos
abrir uma notícia em específico.

<h5>CRIANDO SUA ROTA</h5><p/>

Dentro da pasta "modules" temos a pasta "route", onde você poderá utilizar a rota default, já criada pelo framework ou poderá criar novas
rotas.

Para criar uma nova rota, utilizamos o seguinte código:
    
    $this->post('noticias', function($arg){
        echo "Método POST.";
    })
    
Note que acabamos de criar uma rota com o método POST.

Vamos criar uma rota com o método GET agora.

    $this->get('noticias', function($arg){
            
    });

Para carregar uma página de template na rota, fazemos da seguinte maneira:

    $this->get('noticias', function($arg){
        $tpl = $this->core->loadModule('template');
        $tpl->render('exemplo', $array);
    });

Nós abrimos o módulo de template e depois carregamos o template "exemplo" para o usuário.

Agora vamos abrir um model de notícias e passar dados para o template utilizando a rota, veja:

    $this->get('noticias', function($arg){
        $tpl = $this->core->loadModule('template');
        
        $news = $this->core->loadModule('news');
        
        $array = array();
        $array['news'] = $news->getNewsList();
        
        $tpl->render('exemplo', $array);
    });
    
Aqui abrimos o model "news" e logo depois passamos para o template o resultado da função "getNewsList()".

<h5>CONEXÃO COM BANCO DE DADOS</h5></p>

O arquivo para configurar os dados de conexões se chama "config.php", nele possuímos o seguinte código:

    $config = array(
        'db' => array(
            'host' => '',
            'user' => '',
            'pass' => '',
            'dbname' => ''
        )
    );

Basta preencher as informações com seus dados.

Para efetuar a conexão em seus módulos, utilizamos o seguinte código:

    private $db;

    private function __construct() {
        $core = Core::getInstance();
        $this->db = $core->loadModule('database');
    }

Agora podemos fazer nossas consultas normalmente, utilizando o exemplo citado acima, "getNewsList()", temos:

    public function getNewsList() {
        $array = array();
    
        $sql = $this->db->query("SELECT * FROM noticias");
    
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }
    
<h5>UTILIZANDO DADOS NOS TEMPLATES</h5></p>

Abaixo temos um exemplo de dados sendo utilizados no template.

    <html>
        <body>
            <h1>Notícias:</h1>
    
            <ul>
                <?php foreach($data['news'] as $new): ?>
                    <li><a href="./noticias/<?php echo $new['id']; ?>"><?php echo utf8_encode($new['titulo']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </body>
    </html>
    
Outro exemplo:

    <html>
        <body>
            <a href="../noticias">Voltar</a>
            <h1><?php echo utf8_encode($data['info']['titulo']); ?></h1>
            <p><?php echo utf8_encode($data['info']['corpo']); ?></p>
        </body>
    </html>
