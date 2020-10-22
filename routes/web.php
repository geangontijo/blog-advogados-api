<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Storage;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/users/register', 'UsersController@store');

$router->group(['middleware' => 'JwtAccess'], function () use ($router) {

    $router->group(['prefix' => '/users'], function () use ($router) {
            $router->put('/{userId}', 'UsersController@edit');
            $router->delete('/{userId}', 'UsersController@delete');
            $router->get('/', 'UsersController@index');
    });

    $router->group(['prefix' => '/posts'], function () use ($router) {
        $router->get('/', 'PostsController@index');
        $router->post('/', 'PostsController@store');
    });
});

$router->get('/home', function () {
    $posts = '
        "newPosts":[
          {
            "title": "Direito Civil",
            "alt": "image stock",
            "description": "Elaboração de contratos e litígios envolvendo parcerias, representação comercial, compra e venda, doação, seguros, etc. Consultoria e assessoria em geral; Ações indenizatórias envolvendo danos morais, materiais, erro médico e responsabilidade civil na esfera do Direito do consumidor. Ações possessórias, usucapião; Cobrança de títulos e dívidas em geral.",
            "image": "https://images.unsplash.com/photo-1563126303-227e37edb271?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=312&q=80",
            "link": "/services"
          },
          {
            "title": "Direito Civil",
            "alt": "image stock",
            "description": "Elaboração de contratos e litígios envolvendo parcerias, representação comercial, compra e venda, doação, seguros, etc. Consultoria e assessoria em geral; Ações indenizatórias envolvendo danos morais, materiais, erro médico e responsabilidade civil na esfera do Direito do consumidor. Ações possessórias, usucapião; Cobrança de títulos e dívidas em geral.",
            "image": "https://images.unsplash.com/photo-1563126303-227e37edb271?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=312&q=80",
            "link": "/services"
          },
          {
            "title": "Direito Civil",
            "alt": "image stock",
            "description": "Elaboração de contratos e litígios envolvendo parcerias, representação comercial, compra e venda, doação, seguros, etc. Consultoria e assessoria em geral; Ações indenizatórias envolvendo danos morais, materiais, erro médico e responsabilidade civil na esfera do Direito do consumidor. Ações possessórias, usucapião; Cobrança de títulos e dívidas em geral.",
            "image": "https://images.unsplash.com/photo-1563126303-227e37edb271?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=312&q=80",
            "link": "/services"
          },
          {
            "title": "Direito Civil",
            "alt": "image stock",
            "description": "Elaboração de contratos e litígios envolvendo parcerias, representação comercial, compra e venda, doação, seguros, etc. Consultoria e assessoria em geral; Ações indenizatórias envolvendo danos morais, materiais, erro médico e responsabilidade civil na esfera do Direito do consumidor. Ações possessórias, usucapião; Cobrança de títulos e dívidas em geral.",
            "image": "https://images.unsplash.com/photo-1563126303-227e37edb271?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=312&q=80",
            "link": "/services"
          }
        ]';
    return '{
      "cardMedium":{
        "title":"Dra. Márcia Gabrielle Gontijo de Oliveira",
        "text":"Dra. Márcia Gabrielle Gontijo, inscrita na OAB/MG sob o número 159.743, Mestranda em Direito pela UFMG - Universidade Federal de Minas Gerais, Especilista em Direito Civil e Processo Civil pela Universidade Pitágoras Campus Divinópolis, Bacharel em Direito pela Faculdade de Direito Presidente Antônio Carlos – FUPAC (UNIPAC, Campus Bom Despacho). Presidente da Comissão da OAB Jovem da 144° Subsecção da Ordem dos Advogados de Minas Gerais; Vice Presidente da AACO _ Associação dos Advogados do Centro Oeste de Minas Gerais. Ex-Presidente da Comissão de Direito das Famílias da AACO - Associação dos Advogados do Centro Oeste de Minas Gerais; Membro do IBDFAM - Instituto brasileiro de direito de família; Coachee para Advogados de Abril 2016 a Abril 2017; Palestrante. Possui diversos artigos publicados na área jurídica."
      },
      "cardLarge":{
        "bio":"MARCIA GABRIELLE GONTIJO &ADVOGADOS ASSOCIADOS é um escritório voltado para prestação de serviços jurídicos de qualidade no direito público e privado, especializado em Direito de Família e Sucessões, Direito do Consumidorz, Direito Negocial e Econômico, Direito Tributário e Planejamento Tributário e Familiar, priorizando as práticas colaborativas e a advocacia preventiva buscando sempre o atendimento de excelência, com qualidade e agilidade. Apostamos na eficácia da prestação de serviços jurídicos a clientes (pessoas físicas e jurídicas), atuando também no contencioso.",
        "benefits":[
          {
            "title": "Economize Dinheiro com a Advocacia Mensal.",
            "description": "Assim como um plano de saúde a Advocacia mensal para pessoas físicas trará grandes economias, pois além de redução dos honorários em comparação a serviços contratados individualmente, nosso escritório estará presente em todas as áreas de atuação da sua vida, trabalhando de forma consultiva e preventiva a fim de se evitar futuras perdas. Nossa assessoria inclui parecer sobre contratos firmados, elaboração de minutas contratuais, e as mais diversas orientações sobre as decisões que serão tomadas na sua vida através do ponto de vista técnico jurídico."
          },
          {
            "title": "Suas informações protegidas",
            "description": "Trabalhamos com armazenamento seguro de seus arquivos, portanto todo e qualquer documento entregue ao escritório é armazenado de forma segura e aqueles digitais são colocados em servidores criptografados para evitar qualquer acesso de pessoas não autorizadas. Quando firmamos um contrato, agradecemos a total confiança depositada em nosso trabalho e nada mais justo que termos investido na segurança das informações e dos documentos de nossos clientes entregues ao escritório."
          },
          {
            "title": "Facilidade no pagamento de Honorários",
            "description": "Os honorários advocatícios variam de acordo com o procedimento a ser adotado em cada caso que nos é apresentado, e independente disto procuramos facilitar sempre o recebimento dos honorários de uma forma que você não tenha dificuldades para pagar, trabalhamos com parcelamento diretamente com o escritório e recebimento através de cartões de crédito e débito."
          },
          {
            "title": "Atendimento personalizado",
            "description": "Atendemos nosso cliente de forma personalizada, seu problema é nosso problema. Nossa metodologia de trabalho é no sentido de oferecer o maior conforto ao cliente em um momento de dificuldade, seja para sanar uma dúvida jurídica ou mesmo para ingressar judicialmente com alguma demanda. Nosso escritório conta com os mais modernos meios de atendimento, oferecendo suporte ao cliente através de email, telefone, whatsapp, skype e os atendimentos no próprio escritório."
          }
        ],
      }
    }';
});
