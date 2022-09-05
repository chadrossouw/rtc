(function(){
    const urlParams = new URLSearchParams(window.location.search);
    const page = document.getElementById('primary')
    const container = document.getElementById('response');
    const filterContainer = document.getElementById('filter');
    const filterButtons = filterContainer?.querySelectorAll('.filtering');
    const sortingButtons = filterContainer?.querySelectorAll('.sorting'); 
    let cat;
    let filters = [];
    if(filterContainer){
        cat = filterContainer.dataset.cat
        filterContainer.addEventListener('click',e=>{
            let target = e.target;
            if(target.tagName!='BUTTON'){
                return;
            }
            filterShop(target);
        })
    }

    function filterShop(button){
        page.classList.add('loading');
        let sort,filter;
        if(button.classList.contains('filtering')){
            sortingButtons.forEach(sButton=>{
                if(sButton.classList.contains('active')){
                    sort = sButton.dataset.sort;
                    return;
                }
            });
            filter = button.dataset.slug;
            if(filter!='reset'){
                filters.push(filter);
            }
            else{
                filters=[];
                filterButtons.forEach(fButton=>fButton.classList.remove('active'));
            }
        }
        else{
            sortingButtons.forEach(sButton=>sButton.classList.remove('active'));
            sort = button.dataset.sort;
        }
        button.classList.add('active');

        setParams(sort);
        fetchResponse(sort);
    }

    function setParams(sort){
        if(filters.length==0){
            urlParams.delete('bl_sub_cat');
        }
        else{
            filterJSON = JSON.stringify(filters);
            urlParams.set('bl_sub_cat',encodeURIComponent(filterJSON));
        }
        if(sort){
            urlParams.set('bl_sort',sort);
        }
        urlParams.delete('paged');
        history.pushState('','',`?${urlParams}`);
    }
    
    function fetchResponse(sort){
        filterJSON = JSON.stringify(filters)
        fetch(`/wp-json/reclaimthecity/v1/filter?bl_cat=${cat}&bl_sub_cat=${encodeURIComponent(filterJSON)}&bl_sort=${sort}`)
            .then(response=>response.json())
            .then(data=>{
                changeResponse(data); 
            })
            .catch(error=>{
                console.log(error);
                page.classList.remove('loading');
            });
    }
   
    function changeResponse(data){
        container.innerHTML = data;
        page.classList.remove('loading');
      
    }


    const filterHeader = document.querySelector('.filter-header');
    if(filterHeader && window.innerWidth>700){
        const filterHeaderHeight = filterHeader.clientHeight;
        const container = document.querySelector('#response');
        const margin = window.innerHeight - filterHeaderHeight;
        //const nextSibling = filterHeader.nextElementSibling;
        let flag=0;
        let stickyObserver = new IntersectionObserver((entries, observer) => { 
            entries.forEach(entry => {
                if(entry.isIntersecting && flag == 0){
                    filterHeader.classList.add('fixed');
                    container.style.paddingTop = `${filterHeaderHeight}px`;
                    flag=1;
                }	
                else{
                    flag=0;
                    filterHeader.classList.remove('fixed');
                    container.style.paddingTop = `0px`;
                }
            });
          }, {rootMargin: `0px 0px -${margin}px 0px`});
          stickyObserver.observe(container);
    }
}());