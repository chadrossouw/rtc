(function(){
    const container = document.querySelector('#about_scarabeus');
    const imageDiv = document.querySelector('#about_image');
    const contentDiv = document.querySelector('#about_content');
    const links = document.querySelectorAll('a.rest');

    function isFetchAPISupported() {
        return 'fetch' in window;
    }
    if(isFetchAPISupported()){
        links.forEach(link=>link.addEventListener('click',getResponse));
        
        function getResponse(e){
            e.preventDefault();
            if(e.currentTarget.classList.contains('active')) return;
            links.forEach(link=>link.classList.remove('active'));
            e.currentTarget.classList.add('active');
            container.classList.add('loading');
    
            var id = e.currentTarget.dataset.id;
            
            fetch(`/wp-json/cumulus/v1/about/${id}`)
            .then(response=>response.json())
            .then(data => replaceResponse(data))
            .catch(error=>{
                console.log(error);
                container.classList.remove('loading');
            });
        }
    
        function replaceResponse(data){
            imageDiv.innerHTML = data.image;
            contentDiv.innerHTML = data.text;
            container.classList.remove('loading');
            addContactButtons();
        }
    }
}())


