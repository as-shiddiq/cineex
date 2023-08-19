L.Control.bmSwitcher = L.Control.extend({
    options: {
        position: 'topright',
    },

    initialize: function(layers, options){
        L.Util.setOptions(this, options);
        this.classContainer = 'bmContainer';
        this.classModal = 'bmSwitcher-modal';
        this.layers = layers;
    },

    onAdd: function (map){
        const container = this.container = L.DomUtil.create('div', 'leaflet-control-bmSwitcher');

        const elModalBd = document.createElement('div');
        elModalBd.classList.add('backdrop');
        elModalBd.classList.add(this.classModal);
        document.body.appendChild(elModalBd);

        const elModal = document.createElement('div');
        elModal.classList.add('bmModal');
        elModalBd.appendChild(elModal);

        const elModalClose = document.createElement('div');
        elModalClose.innerHTML = `<span>&#10005;</span>`;

        elModal.innerHTML =`<div class="bmHeader">
                                <div><h3>BaseMap</h3></div>
                                <div class="bmClose"></div>
                            </div>
                            <div class="bmBody"></div>`;
        
        elModal.querySelector('.bmClose').appendChild(elModalClose);
        this._createItems();
        this._collapse();
        this._init();

        elModalClose.addEventListener('click',()=>{
            this._collapse();
        })
        return container;
    },

    _createItems() {
        const bmContainer = L.DomUtil.create('div', this.classContainer);
        this.layers.forEach( (obj, index) => {
            obj.id = index

            const imgContainer = L.DomUtil.create('div', 'bmImage');
            const img = L.DomUtil.create('div');
            const name = L.DomUtil.create('div', 'name');
            const check = L.DomUtil.create('div', 'check');
            name.innerHTML = obj.name

            if(obj.layer?._map){
                this.activeMap = obj
                check.classList.add('active');
            }
            
            img.style.backgroundImage = `url(${obj.icon})`;
            imgContainer.append(img)
            img.append(check)
            img.append(name)
            
            imgContainer.addEventListener('click', () =>{

                this._removeLayers(obj.layer);
                
                if(!obj.layer?._map){
                    obj.layer.addTo(this._map);
                    obj.layer.bringToBack()
                    this.activeMap = obj;
                    this._collapse();
                    this._map.fire('basemapChange', { layer : obj.layer });
                    check.classList.add('active');
                }

            })
            bmContainer.append(imgContainer)
        });
        this.container.append(bmContainer)
    },

    _removeLayers(layer){

        this.layers.forEach( (obj) =>{
            if(obj.layer._leaflet_id !== layer._leaflet_id && obj.layer?._map) {
                this._map.removeLayer(obj.layer);
            }
        })
    },

    _collapse(){
        let elModal = document.querySelector(`.${this.classModal}`);
        let elModalContainer = elModal.querySelector(`.${this.classContainer}`);
        let w = window.innerWidth;
        if(w<=767)
        {
            elModal.classList.add('hide');
            elModal.classList.remove('show');
            setTimeout(()=>{
                elModal.classList.remove('hide');
            },300);
        }

        if(elModalContainer!=null)
        {
            this.container.appendChild(elModalContainer);
        }
        this.container.querySelector(`.${this.classContainer}`).childNodes.forEach( (child, index) => {
            if(index !== this.activeMap.id){
                child.classList.add('bmHidden')
                let check = child.querySelector('.check')
                check.classList.remove('active')
            }
        });
    },

    _expand(){
        let w = window.innerWidth;
        if(w>767)
        {
            this.container.querySelector(`.${this.classContainer}`).childNodes.forEach( (child) => {
                child.classList.remove('bmHidden')
            })
        }
        else
        {
            let elModal = document.querySelector(`.${this.classModal}`);
            this.container.querySelector(`.${this.classContainer}`).childNodes.forEach( (child) => {
                child.classList.remove('bmHidden')
            })
            elModal.querySelector('.bmBody').appendChild(this.container.childNodes[0]);
            elModal.classList.add('show');
        }
    },

    _init(){
        this.container.querySelector(`.${this.classContainer}`).addEventListener('mouseout', () => {
            if(window.innerWidth>767)
            {
                this._collapse();
            }

        });

        this.container.querySelector(`.${this.classContainer}`).addEventListener('mouseover', () => {
            if(window.innerWidth>767)
            {
                this._expand();
            }
        });

        this.container.addEventListener('click', () => {
            if(window.innerWidth<=767)
            {
                this._expand();
            }
        })
    }
})

L.bmSwitcher = function(layers, options){
    return new L.Control.bmSwitcher(layers, options);  
}