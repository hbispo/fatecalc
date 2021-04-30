<?php

final class Config
{
    //Dados de conexão: endereço, usuário, senha, banco de dados
    const banco = ['localhost', 'fatecalc', 'fatecalc', 'fatecalc'];

    const atualizacao = 0;

    /*Para acrescentar um item no menu, seguir o formato
    * ['Texto', 'icone-do-font-awesome', 'pagina.php', [submenu]]
    * (ícones, páginas e submenus opcionais)
    */
    const menu = [
        ['Home', 'home', './', 1],
        ['Tutorial', 'question-circle', 'tutorial.php', 1],
        ['Sair', 'sign-out-alt', 'login.php', 1]
    ];

    public static function rodape()
    {
        return '<footer class="text-center">
            Desenvolvido por <a href="https://github.com/hbispo">Henrique Bispo</a> sob uma <a href="https://github.com/hbispo/fatecalc/blob/master/LICENSE">licença MIT</a>. Código-fonte no <a href="https://github.com/hbispo/fatecalc">GitHub</a>.
        </footer>';
    }
}
