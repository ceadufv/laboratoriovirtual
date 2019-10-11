class PageAnimation {
    /*
    var data = [
        {img: 'assets/actions/lavareletrodo.gif', 'title': ''},
        {img: 'assets/actions/secareletrodo.gif', 'title': ''},
    ];
    */
    static open(dados) {
        Laboratorio.pause();
        console.warn('PageAnimation.open', 'PageAnimation');
       
        PageAnimation.page = 0;
        PageAnimation.page_total = dados.length - 1;
        for (let i = 0; i < dados.length; i++) {
            if(!dados[i].title){
                dados[i].title = '';
            }
            $('#animacao .modal-body .conteudo').append('<div id="a-page-' + i + '" class="page page-' + i + ' a-page"><h1>'+dados[i].title+'</h1><img src="' + dados[i].img + '" /></a>');
            
        }
        $('#animacao').modal('show');
        PageAnimation.pageShow(0);
    }

    //PageAnimation.pageShow(0);
    static pageShow(id) {
        PageAnimation.hideAllPage();
        PageAnimation.page = id;

        if (PageAnimation.page <= 0)
            PageAnimation.page = 0;
    
        if (PageAnimation.page > PageAnimation.page_total)
            PageAnimation.page = PageAnimation.page_total;
        
        if(PageAnimation.page == PageAnimation.page_total)
            $('#animation-next-page').addClass('disabled');
        else{
            $('#animation-next-page').removeClass('disabled', false);
        }

        if(PageAnimation.page == 0)
            $('#animation-previous-page').addClass('disabled');
        else{
            $('#animation-previous-page').removeClass('disabled', false);
        }

        console.warn('PageAnimation.pageShow', 'PageAnimation');
        console.warn(PageAnimation.page, 'PageAnimation');
        $('#a-page-' + PageAnimation.page).show();
    }
    static hideAllPage() {
        $('.a-page').hide();
    }
    static nextPage() {
        console.warn('PageAnimation.nextPage', 'PageAnimation');
        PageAnimation.pageShow(PageAnimation.page + 1);
    }
    static previousPage() {
        console.warn('PageAnimation.previousPage', 'PageAnimation');
        PageAnimation.pageShow(PageAnimation.page - 1);
    }
}