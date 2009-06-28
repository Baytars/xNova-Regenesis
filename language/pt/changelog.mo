<?php
$lang['Version']     = 'Vers�o';
$lang['Description'] = 'Descri��o';
$lang['changelog']   = array(

'<font color="lime">0.8h es</font>' => 'revision 343 svn
-ADD: Turca acrescentado - edição em curso.
-FIX: Aplicado Fix para impedir a destrui��o de lua a jogadores fracos / fortes (Neurus)
-FIX: Adicionadas modalidade ao sistema de plugins (Perberos)
-FIX: Nova formula de calculo de tamanho das col�nias (Minguez)
-FIX: Fila de constru��o de edificios (Minguez)
-MOD: Recursos para todos (SainT)
-FIX: Adic��o de seguran�a para evitar injec��es SQL (Perberos)
-MOD: Actualiza��o do sistema de plugins, adicionando-se a vers�o do plugin como vari�vel (Perberos)
-FIX/MOD:  troca de include por include_once no ficheiro de linguagem a fim de evitar hacking de HTML nos templates (Perberos)
-FIX: Permitir a utiliza��o de &aacute;,&eacute;,&iacute;,&oacute;,&uacute;,&ntilde;, etc (Neurus)
-FIX: patch para pathinfo PHP 4.0.3 > 5.2.0 (Perberos)
-FIX: Correc��o do bug da galaxia 1:1 (angelus_ira)
-MOD: Novo link para a galaxia em unlocalised.php para os links de frotas (angelus_ira)
-FIX: Pequenas correc��es na Galaxia_body_new.tpl  (angelus_ira)
-FIX: Tempo de constru��o / investiga��o (Neurus)
-EXT: Limpeza do c�digo do menu esquerdo (Perberos)
-MOD: Readicionado o Mercador. (Perberos)
-MOD: Pequena altera��o da vers�o dos links (Perberos)
-ADD: Adicionado o ficheiro version.txt (Perberos)
-FIX: Na tooltip da galaxia, mostra os destro�os reais e n�o os recursos do planeta (DarkSoldier)
-TRAD: Adicionada a linguagem Portuguesa (PT) (Visigod)
-TRAD: Adicionada a linguagem Inglesa (PT) (Visigod)
-EXT: Changelog actualizado (angelus_ira)
',

'0.8e es' => 'revision 160 svn
-FIX: Correc��o dos links dos popups nos combates e espionagem (fun��o javascript) (Pada)
-EXT: Limpeza do c�digo em buddy.php e adicionado o  buddy_sendform.tpl (Perberos)
-FIX: Pequeno fix de HTML nos templates de admin/server (Perberos)
-FIX: Remo��o de problemas nos cabe�alhos da cache do browser (Perberos)
-FIX: Remo��o dos ficheiros Galaxia-new.php e Galaxia_body_new.tpl (Pada)
-MOD: BANIP MOD incluido no todofleetcontrol.php (Pada)
-MOD: A entrada e saida � gerida atrav�s de SESSIONS (adi��o de functions/SessionFunctions.php e USER_SESSION no constants.php) (Pada)
-MOD: Apenas 1 IP permitido em simultaneo por conta (Pada)
-TRAD/FIX: alterados os caracteres �,� �, �, � y � por caracteres standard (angelus_ira)
-FIX: Alterados os <br> por <br /> nos templates para suporte de XHTML (angelus_ira)
-DEL: Apagados os templates sem utiliza��o (angelus_ira)
-FIX: Corrigidos erros no phalanx com a nova gal�xia (Pada)
-FIX: Corrigida a formula de alcance do Phalanx (Pada)
-FIX: login.php (Pada)
-FIX: Mudan�a do HTML do ficheiro frames.php para templates (Perberos)
-OPT: Optimiza��o do chat. (Perberos)
-OPT: Optimiza��o do ficheiro todofleetcontrol.php (Perberos)
<font color="red">-MOD/ADD: Inclus�o do novo sistema de plugins</font> (Perberos)
-EXT: Changelog actualizado (angelus_ira)
',

'0.8d es' => 'revision 147 svn
-FIX: Cr�ditos corrigidos (angelus_ira) 
-MOD: Modifica��o do overview_body.tpl  (angelus_ira)
-FIX: Fix de bugs de seguran�a, bloqueio e redirecionamento de utilizadores n�o identificados (Perberos)
-FIX: Pequeno bug na lista de amigos
-TRAD: Come�ou-se a utilizar as tradu��es do Sr.Nene. Todos os ficheiros em unicode sem BOM
-FIX/ADD: Adicionados cabe�alhos nalguns arquivos. Patch de seguran�a aplicado. (inclus�o de ficheiros remotos) (Perberos)
-FIX: Pequeno fix no template de login e no ficheiro de linguagem
-MOD/ADD: - Adicionado "messages-new.php" e "messages.tpl", baseado no TemplatePower. Ajax para limpeza das mensagens. (Pada)
-MOD/ADD: - messages_pm_form.tpl modificado para permitir a utiliza��o de "smilies". (Pada)
-MOD/ADD: - Adicionadas fun��es para smilies no ficheiro functions.php. (Pada)
-MOD/ADD: - functions.js tem uma nova fun��o: "putSmilie" (Pada)
-FIX: Erro na instala��o (Perberos)
-EXT: Limpeza do c�digo e tradu��o de coment�rios (Perberos)
-EXT: Adicionados os copylefts ao cabe�alho dos ficheiros (Perberos)
-FIX: Devolu��o dos recursos ao cancelar uma investiga��o (DarkSoldier)
-ADD: Pode-se efectuar o download do config.php durante a instala��o (Perberos)
-EXT: Changelog actualizado (angelus_ira)
',

'0.8c es' => 'revis�o 134 svn
-ADD: Adicionado o TemplatePower ao common.php (Pada)
-MOD/OPT: PadaGalaxia v0.3 implementado com sucesso mas n�o adicionado ao left_menu.tpl (Pada)
-ADD: Adicionada a referencia a fleet.mo na espera do retorno de frota em Galaxia-new.php (Pada)
-ADD: Adicionado jquery.js como entrada �nica (evitar vers�es posteriores com nomes diferentes) (Pada)
-TRAD: Tradu��es do buddy, banned, corrigido o menu esquerdo e tradu��o completa do menu de frotas (angelus_ira)
-FIX: Sistema de misseis (Minguez)
-FIX: Correc��es � alian�a  (angelus_ira) 
-MOD: Modifica��o do login (darksoldier)
-MOD: Sistema de help desk (Tickets) (darksoldier) 
-MOD: Novo Overview (darksoldier, angelus_ira)
-MOD: Visualiza��o do limite m�ximo de constru��o de frota
-EXT: Readme em espanho e frances
-MOD: Informa��o do Servidor
-TRAD: Mensagem de op��es guardadas na parte de administra��o
-EXT: Changelog actualizado 
',

'0.8b es' => 'revision 83 svn
-FIX: Corrigido o arquivo de linguage da instala��o
-ADD: Ban por IP (lyra, http://project.xnova.es/viewtopic.php?f=11&t=389)
-FIX: Modo de f�rias (Prethorian, http://project.xnova.es/viewtopic.php?f=10&t=65&st=0&sk=t&sd=a)
-FIX: Negociador (Neurus, http://project.xnova.es/viewtopic.php?f=10&t=18)
-FIX: Unknown column in field list (Neurus, http://project.xnova.es/viewtopic.php?f=10&t=434)
-FIX: Evitar entrar sem estar conectado (Leeloo, http://project.xnova.es/viewtopic.php?f=21&t=85)
-FIX: Modo de debug corrigido e a funcionar a 100% (adri93, http://project.xnova.es/viewtopic.php?f=10&t=371)
-FIX: Divis�o por 0 (Neurus, http://project.xnova.es/viewtopic.php?f=10&t=526)
-FIX: Limitar pedidos � alian�a quando esta estiver fechada: (Saint, http://project.xnova.es/viewtopic.php?f=10&t=7)
-FIX: Rank dos membros na lista de membros da alian�a: (angelus_ira, http://project.xnova.es/viewtopic.php?f=10&t=41)
-FIX: Transferir alian�a (Pseudo add): (angelus_ira, http://project.xnova.es/viewtopic.php?f=10&t=458)
-FIX: Ordena��o por pontos na lista de membros: (mac, http://forum.ragezone.com/showthread.php?t=456323 )
-FIX: Texto de solicita��o da alian�a (interno e externo): (angelus_ira, http://project.xnova.es/viewtopic.php?f=10&t=135)
-MOD/TRAD: Modificados varios templates e tradu��o quase total da alian�a
-OPT: Optimizaci&oacute;n de galaxia (Marcos, Pada, http://project.xnova.es/viewtopic.php?f=10&t=465)
-FIX: Abandonar colonia (angelus_ira, http://project.xnova.es/viewtopic.php?f=10&t=701)
-FIX: records.php (Minguez, http://project.xnova.es/viewtopic.php?f=30&t=699&start=0&st=0&sk=t&sd=a)
-MOD: Elimina��o da utiliza��o da tabela lunas (angelus_ira, http://project.xnova.es/viewtopic.php?f=30&t=702)
-OPT: Optimiza��o da lista de membros da alian�a (angelus_ira)
-FIX: Destruir lua (prethorian)
-FIX: Pequenas altera��es no template da lista de membros
-MOD: Modifica��o do sistema de an�ncios pelo do Xnova 0.9
-ADD/TRAD: Overview completamente traduzido e com pontos das defesas
',

'0.8a es' => 'Inicio da actividade do Project.Xnova
-FIX: Evite entrar nas frames sem estar conectado 
-FIX: Nomes dos planetas da gal�xia (saint, http://project.xnova.es/viewtopic.php?f=10&t=43)
-FIX: Abandonar Colonias e Luas (Minguez, http://project.xnova.es/viewtopic.php?f=10&t=582)
-FIX: Permitir apenas a utiliza��o de caracteres alfanum�ricos nos planetas (Leeloo,http://project.xnova.es/viewtopic.php?f=10&t=45)
-FIX: Link para estat�sticas das alianzas (upsala20, http://project.xnova.es/viewtopic.php?f=10&t=141) 
-ADD: Adicionada a miss�o de destruir lua (prethorian ,http://project.xnova.es/viewtopic.php?f=10&t=686)
-FIX: Corrigido o ficheiro tech.mo (angelus_ira)
-FIX: Espiar sem sondas (Neurus y bol,http://project.xnova.es/viewtopic.php?f=10&t=132)  
-FIX: Defesas (Bjenkin, http://project.xnova.es/viewtopic.php?f=10&t=113)
-MOD: Modifica��o da base de dados proposto por teyla
-FIX: Oficial destruidor (http://project.xnova.es/viewtopic.php?f=10&t=546)
-FIX: Utilizadores e email em options.php (Leeloo, http://project.xnova.es/viewtopic.php?f=10&t=348)
-FIX: Op��es e n�o apenas alterar a palavra-pass (SainT, http://project.xnova.es/viewtopic.php?f=10&t=40)',

'0.8' => 'Infos (Chlorel)
- FIX: Skin para a nova instala��
- DIV: Trabalho de est�tica em v�rios ficheiros
- FIX: Altera��o para a chamada de fun��es implementadas recentemente',

'0.7m' => 'Corre��es de bugs (Chlorel)
- ADD: Interface activa��o da protec��o dos planetas 
- FIX: As luas sao atribuiadas a um novo utilizador e nao ao proprio utilizador quando criadas a partir do menu de administra��o
- FIX: Vis�o Geral para eventos de frota (apenas frota pessoal) agora a utilisar o CSS (default.css) 
- MOD: Adapta��o de diversas fun��es � utiliza��o da css
- FIX: Chat interno (ajustes diversos) (e-Zobar)',

'0.7k' => 'Corre��es de bugs (Chlorel)
- FIX: Retorno do transporte da frota
- ADD: Protec��o dos planetas dos Administradores
- MOD: Lista de jogadores na sec��o de administra��o. Links sobre cabe�alhos para ordenar os campos.
- MOD: P�gina geral de administra��o. Sec��o com links nos cabe�alhos para ordena��o
- FIX: Ao alterar a skin do jogo, a mesma tamb�m � aplicada � parte de administra��o
- FIX: "Adicionar uma lua" no painel de administra��o
- ADD: Modo de transfer�ncia de dados no instalador (e-Zobar)',

'0.7j' => 'Corre��es de bugs (Chlorel)
- FIX: Pode ser removida uma constru��o na lista de constru��es
- FIX: Pode-se enviar uma nova frota de transporte entre os dois planetas
- FIX: Lista de atalhos na lista de constru��es
- FIX: N�o se pode destruir n�veis de edif�cios que ainda n�o temos
- ADD: Novo e embelezado instalador (e-Zobar)
- FIX: Remo��o de hier�glifos (e-Zobar)',

'0.7i' => 'Corre��es de bugs (Chlorel)
- Supress�o do cheat +1
- Ajuste da dura��o dos voos / consumo da frota entre o c�digo PHP e o c�dgio Java
- Classifica��o das col�nias no menu de op��es do jogador
- Prepara��o das op��es para multiskin
- Diversas melhorias no c�digo de Administra��o (Lista de Mensagens e de Jogadores)
- Trabalho na skin (e-Zobar)
- Trabalho no instalador (e-Zobar)',

'0.7h' => 'Corre��es de bugs (Chlorel)
- Interface dos Oficiais refeito
- Ajustado o bloqueio do "meta refresh"
- Correc��o de diversos bugs
- Correc��o de diversos textos (flousedid)
- Correc��o dos efeitos visuais padr�o (e-Zobar)',

'0.7g' => 'Correc��es diversas (Chlorel)
- Mudan�a na forma de tratamento na lista de constru��o de edif�cios
- Standariza��o do c�digo utilizando apenas chamadas do tipo "echo"
- Alguns m�dulos reescritos
- Correc��o do bug de duplica��o de frota
- Actualiza��o do tamanho dos silos e da produ��o das minas e energia
- V�rios ajustes na sec��o de administra��o (e-Zobar)
- Modifica��o do estilo do XNova (e-Zobar)',

'0.7f' => 'Informa��es e Portal de Salto Qu�ntico: (Chlorel)
- Nova p�gina de informa��es e o seu completo redesenho
- Nova interface integrada do portal de salto quantico
- Nova gest�o da exibi��o de rapid-fire na p�gina de informa��es 
- Multiplas corre��es feitas pelo e-Zobar',

'0.7e' => 'Em v�rias partes do c�digo : (Chlorel)
- Nova p�gina de registo (defini��o standard)
- Nova p�gina de records (defini��o standard)
- Modifica��o do kernel (existiram v�rias altera���es mas � dificil explicar tudo o que se fez.
  Al�m disso v�rias pessoas n�o compreenderiam mais de metade do que foi feito',

'0.7d' => 'Parte admin : (e-Zobar)
- Gest�o de v�rios m�dulos
- Alinhamento do menu ao estilo de funcionamento do site
- Concluir a tradu��o do que ainda n�o estava em Franc�s',

'0.7c' => 'Estat�sticas : (Chlorel)
- Elimina��o das chamadas � base de dados do antigo sistema de estat�sticas
- Bug que impossibilita fazer defesas ou frota que n�o utilizam metal
- Bug em como certos jogadores se divertem a fazer enormes quantidades de frota no menu de construcao de frota.
  Limitamos o numero de elementos a fabricar por tipo em 1000 de frota ou de defesas ao mesmo tempo!!
- Bug erro na escolha do planeta pela combo box
- Instalador actualizado',

'0.7b' => 'Estat�sticas : (Chlorel)
- Reescrita da p�gina de estat�sticas (quando chamado pelo utilizador)
- Estados da alian�a corrigidos
- Elabora��o das estat�sticas do administrador
- Separa��o das estat�sticas do registro de utilizadores (as estat�sticas s�o sobre a base de dados)',

'0.7a' => 'Diversos : (Chlorel)
- Bug Tecnologias (a dura��o da investiga��o aparece de novo quando se retorna ao laborat�rio)
- Bug M�sseis (refeita toda a gama de m�sseis interplanet�rios e aplica��o do limite de produ��o comparando com o tamanho do silo) 
- Bug do Phalanx corrigido (n�o se pode utilizar o phalanx em toda a gal�xia) 
- Bug Fix do consumo de deut�rio quando se passa atrav�s do menu gal�xia',

'0.7' => 'Edif�cio :
- Novo c�digo da p�gina
- Modulariza��o
- Correc��o dos bugs de estat�sticas
- Debug da lista de constru��o de edif�cios
- Retoques diversos (Chlorel)
- Debugs diversos (e-Zobar)
- Adi��o de fun��o sobre a vista principal (Tom1991)',

'0.6b' => 'Diversos :
- Correc��o e Adi��es de fun��es para os oficiais (Tom1991)
- Gest�o dos scripts Java incluidos no c�digo (Chlorel)
- Correc��o de diversos bugs (Chlorel)
- Instaurado vers�o 0.5 da lista de constru��o constru��es (Chlorel)',

'0.6a' => 'Grafismo :
- Ajuste da Skin XNova (e-Zobar)
- Correc��o de efeitos nefastos (e-Zobar)
- Ajuste de bugs involunt�rios (Chlorel)',

'0.6' => 'Galaxia (suite): (por Chlorel)
- Modifica��o e nova redac��o do flottenajax.php
- Modifica��o da rotina javascript e ajax para permitir a modifica��o din�mica da gal�xia
- Correc��es de bug em certas janelas de popups
- Defini��o do novo protocolo de chamada a partir de uma lua na gal�xia
- Correc��o das chamadas de reciclagem
- Adi��o do m�dulo de "Oficial" (por Tom1991)',

'0.5' => 'Galaxia: (por Chlorel)
- Remo��o dos m�dulos antigos
- Modifica��o do sistema de gera��o de popup da vista da gal�xia
- Modulariza��o da gera��o da p�gina',

'0.4' => 'Vista Geral: (por Chlorel)
- Formata��o do m�dulo antigo
- Gest�o de envio de frota (100%)
- Altera��o da exibi��o de luas quando presentes
- Correc��o da altera��o do nome das luas (para que sejam realmente renomeadas)',

'0.3' => 'Gest�o da frota: (por Chlorel)
- Modifica��o / modulariza��o / documenta��o do ciclo de gest�o (100%)
- Mudan�a na miss�o de espionagem (100%)
- Mudan�a na miss�o de Coloniza��o (100%)
- Mudan�a na miss�o de Transporte (100%)
- Mudan�a na miss�o de Estacionamento (100%)
- Mudan�a na miss�o de Reciclagem (100%)',

'0.2' => 'Correc��es
- Adi��o da vers�o 0.5 de Explora��o (pelo Tom1991) 
- Modifica��o do ciclo de controle de frotas (10%) (por Chlorel)',

'0.1' => 'Jun��o das vers�es de frota:
- Implementar a estrat�gia de desenvolvimento
- Cria��o de novas p�ginas de gest�o da frota',

'0.0' => 'Vers�o Inicial:
- Repack a partir da base Tom1991',
);

?>