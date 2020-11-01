var vthis = new Vue({
  el : "#app",
  data () {
    return {
      url : 'http://osemarket.local/api/v1/',
      tokenConfig : {
        'authorization' : 'd24adeac-591e-4e20-92b4-11dd6f427002',
        'Content-Type':'multipart/form-data'
      },
      errorPopup : false,
      errorPopupClass :['popup','u-animation-FromTop','popup__info'],
      errorPopupConfig : {
        "title" : null,
        "message" : []
      },
      errorMessageIsArray : false,
      displayModal : false,
      modalClassIcon : ['icons','icon-arrows-circle-plus','u-font-size-10x'],
      showFormHouseData : false,
      tabImageHouseUpload : [[0,'uploads/file_static/default-upload.png',false]],
      tabImageIncrement : 0,
      avatarMain : 'uploads/file_static/default-upload.png',
      defaultImage : 'uploads/file_static/default-upload.png',
      actionButton : 'Insert',
      provinceData : [],
      districtData : [],
      sectorData : [],
      cellData : [],
      villageData :[],
      fileMain : null,
      fileListImage : [],
      DataProperties : [],
      DataSimulaire :[],
      showSqleton : true,
      tabSqleton : 15,
      MenuShift : true,

      // LOAD FORM TENDERS FIELDS
      title:"",
      entreprise :"",
      deadline :"",
      linkapply :"",
      description :"",
      datapublished :"",

      //LOAD FORM Auctions
      lieu: "",

      tabDivers:[0]
    }
  },
  created () {
    this._getAllProvince();
    // CHECKING PATH TO LOAD SPECIFIC METHOD
    this._u_fx_to_verify_router();

  },
  methods : {
    /*
    * FONCTIONS LOGIQUES
    */
  changeModalState(){ //Fonction pour afficher le modal
    this._u_fx_to_empty_field();
    this._u_fx_to_empty_field_images();
    if(!this.displayModal){
      this.modalClassIcon = ['icons','icon-arrows-circle-remove','u-font-size-10x'];
    }else{
      this.modalClassIcon = ['icons','icon-arrows-circle-plus','u-font-size-10x'];
    }
    this.displayModal = !this.displayModal;

  },

  /*
  *@@@@ Fonction pour afficher Formulaire Pour ajout image sur Formulaire Maison
  */
  fx_showFormHouseData(){
    this.showFormHouseData = !this.showFormHouseData;
  },

  /*
  *@@@@ Fonction pour ajouter une autre image sur les images a plusieurs a uploader Formulaire Properties
  */
  fx_addOneImage(){
    if(this.tabImageHouseUpload[this.tabImageHouseUpload.length-1][2]){
      this.tabImageIncrement++;
      var arr = [this.tabImageIncrement, this.defaultImage, false];
      this.tabImageHouseUpload.push(arr);
    }else{
      const msg = ['You must choose previous image'];
      this.u_fx_config_error_message('Error Image',msg,'popup__danger');
    }

  },
  /*
  *@@@@ Fonction pour supprimer une autre image a uploader Formulaire Properties
  */
  fx_removeSpecificImage(index){
    this.tabImageHouseUpload.splice(index,1);
    this.fileListImage.splice(index,1);
  },
  fx_DisplayImageToUpload(e){
    const image = e.target.files[0];
    let reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = e =>{
      this.avatarMain = e.target.result;
    }
    this.fileMain = image;

  },
  fx_DisplayImageToUploadOther(e){
    const image = e.target.files[0];
    const index = e.target.id;
    let reader = new FileReader();
    reader.readAsDataURL(image);
    reader.onload = e =>{
      this.tabImageHouseUpload[index][1] = e.target.result;
      this.tabImageHouseUpload[index][2] = true;
      var arr = this.tabImageHouseUpload[index];
      this.tabImageHouseUpload.splice(index,1);
      this.tabImageHouseUpload.push(arr);
    }
    if(this.fileListImage[index]===undefined){
      this.fileListImage.push(image);

    }else{
      console.log('index exist');
      this.fileListImage.splice(index,1,image);
    }
  },
  /*
  * FONCTIONS ACTIONS
  */
  create_properties(e){
    e.preventDefault();
    const newurl = this.url+"properties-post-one";
    console.log('hello');
    var form = this._u_fx_create_form_data_property();
    // console.log(form);
    if(form =='errors'){
      this.u_fx_config_error_message("Error Image",['You need to select the main image and one or more detail\'s image'],'popup__danger');
      return;
    }
    return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              console.log(response.data.message);
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.u_fx_config_error_message("Success Data",[err],'popup__success');
                  this._u_fx_to_empty_field_images();
                  this._u_fx_to_empty_field();
                  this.get_properties();
                  return;
                }
                // alert('Errors');

                var err = response.data.message.errors;
                this.u_fx_config_error_message("Error Data",Object.values(err),'popup__danger');

            })
            .catch(error =>{
              console.log(error);

            })

  },
  create_cars(e){
    e.preventDefault();
    const newurl = this.url+"cars-post-one";
    var form = this._u_fx_create_form_data_cars();
    // console.log(form);
    if(form =='errors'){
      this.u_fx_config_error_message("Error Image",['You need to select the main image and one or more detail\'s image'],'popup__danger');
      return;
    }
    return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              console.log(response.data.message);
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.u_fx_config_error_message("Success Data",[err],'popup__success');
                  this._u_fx_to_empty_field_images();
                  this._u_fx_to_empty_field();
                  this.get_cars();
                  return;
                }
                // alert('Errors');

                var err = response.data.message.errors;
                this.u_fx_config_error_message("Error Data",Object.values(err),'popup__danger');

            })
            .catch(error =>{
              console.log(error);

            })

  },
  get_properties(){
    const newurl = this.url+"properties-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            // exit();
            this.showSqleton = false;
            this.DataProperties = response.data.data;
            console.log(this.showSqleton);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_properties_detail(id){
    const newurl = this.url+"properties-get-one/"+id+"/property";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{

            // exit();
            // this.showSqleton = false;
            console.log(this.DataProperties.length);
            this.DataProperties.push(response.data.data);
            this.DataSimulaire.push(this.DataProperties[0].simulaire);
            // console.log('########simulaire');
            // console.log(this.DataSimulaire[0]);
            // console.log(this.showSqleton);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_cars(){
    const newurl = this.url+"cars-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.showSqleton = false;
            this.DataProperties = response.data.data;
            console.log(this.showSqleton);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_cars_detail(id){
    const newurl = this.url+"cars-get-one/"+id+"/cars";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.DataProperties.push(response.data.data.car);
            this.DataSimulaire.push(response.data.data.simulaire);
            console.log(this.DataSimulaire[0]);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  create_tenders(e){
    e.preventDefault();

    vthis.datapublished = e.path[4].childNodes[4].children[0].children[1].children[1].value;
    vthis.deadline = e.path[4].childNodes[4].children[1].children[1].children[1].value
    vthis.description = e.path[4].children[4].children[0].children[1].children[2].value;
    const newurl = this.url+"tenders-post-one";
    var form = this._u_fx_create_form_data_tenders();
    if(form =='errors'){
      this.u_fx_config_error_message("Error Image",['You need to choose logo and files attachment\'s'],'popup__danger');
      return;
    }
    return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.u_fx_config_error_message("Success Data",[err],'popup__success');
                  this._u_fx_to_empty_field_images();
                  this._u_fx_to_empty_field();
                  this.get_tenders();
                  e.path[4].childNodes[4].children[0].children[1].children[1].value = "";
                  e.path[4].childNodes[4].children[1].children[1].children[1].value = "";
                  e.path[4].children[4].children[0].children[1].children[2].value = "";
                  return;
                }
                // alert('Errors');

                var err = response.data.message.errors;
                this.u_fx_config_error_message("Error Data",Object.values(err),'popup__danger');

            })
            .catch(error =>{
              console.log(error);

            })
  },
  get_tenders(){
    const newurl = this.url+"tenders-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.showSqleton = false;
            this.DataProperties = response.data.data;
            console.log(this.DataProperties);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_tenders_detail(id){
    const newurl = this.url+"tenders-get-one/"+id+"/tenders";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.DataProperties.push(response.data.data);
            console.log(this.DataProperties[0]);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_jobs(){
    const newurl = this.url+"jobs-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.showSqleton = false;
            this.DataProperties = response.data.data;
            console.log(this.DataProperties);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_jobs_detail(id){
    const newurl = this.url+"jobs-get-one/"+id+"/jobs";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.DataProperties.push(response.data.data);
            console.log(this.DataProperties[0]);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  create_jobs(e){
    e.preventDefault();

    vthis.datapublished = e.path[4].childNodes[4].children[0].children[1].children[1].value;
    vthis.deadline = e.path[4].childNodes[4].children[1].children[1].children[1].value
    vthis.description = e.path[4].children[4].children[0].children[1].children[2].value;
    const newurl = this.url+"jobs-post-one";
    var form = this._u_fx_create_form_data_tenders();
    if(form =='errors'){
      this.u_fx_config_error_message("Error Image",['You need to choose logo and files attachment\'s'],'popup__danger');
      return;
    }
    return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.u_fx_config_error_message("Success Data",[err],'popup__success');
                  this._u_fx_to_empty_field_images();
                  this._u_fx_to_empty_field();
                  this.get_jobs();
                  e.path[4].childNodes[4].children[0].children[1].children[1].value = "";
                  e.path[4].childNodes[4].children[1].children[1].children[1].value = "";
                  e.path[4].children[4].children[0].children[1].children[2].value = "";
                  return;
                }
                // alert('Errors');

                var err = response.data.message.errors;
                this.u_fx_config_error_message("Error Data",Object.values(err),'popup__danger');

            })
            .catch(error =>{
              console.log(error);

            })
  },
  get_auctions(){
    const newurl = this.url+"auctions-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.showSqleton = false;
            this.DataProperties = response.data.data;
            console.log(this.DataProperties);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  get_auctions_detail(id){
    const newurl = this.url+"auctions-get-one/"+id+"/auctions";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
            this.DataProperties.push(response.data.data.car);
            this.DataSimulaire.push(response.data.data.simulaire);
            console.log(this.DataSimulaire[0]);
            })
            .catch(error=>{
              console.log(error);
            })
  },
  create_auctions(e){
    e.preventDefault();

    vthis.datapublished = e.path[4].childNodes[4].children[0].children[1].children[1].value;
    vthis.deadline = e.path[4].childNodes[4].children[1].children[1].children[1].value
    vthis.description = e.path[4].children[4].children[0].children[1].children[2].value;
    const newurl = this.url+"auctions-post-one";
    var form = this._u_fx_create_form_data_auctions();
    if(form =='errors'){
      this.u_fx_config_error_message("Error Image",['You need to choose logo and files attachment\'s'],'popup__danger');
      return;
    }
    return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.u_fx_config_error_message("Success Data",[err],'popup__success');
                  this._u_fx_to_empty_field_images();
                  this._u_fx_to_empty_field();
                  this.get_auctions();
                  e.path[4].childNodes[4].children[0].children[1].children[1].value = "";
                  e.path[4].childNodes[4].children[1].children[1].children[1].value = "";
                  e.path[4].children[4].children[0].children[1].children[2].value = "";
                  return;
                }
                // alert('Errors');

                var err = response.data.message.errors;
                this.u_fx_config_error_message("Error Data",Object.values(err),'popup__danger');

            })
            .catch(error =>{
              console.log(error);

            })
  },



  // FONCTIONS UTILITIES COMMUNES
  u_fx_config_error_message(title, message, classError){
    this.errorPopupClass.splice(2,1);
    this.errorPopupClass.push(classError);
    this.errorPopupConfig.title = title;
    this.errorPopupConfig.message = [];
    this.errorPopupConfig.message.push(message);
    // console.log('##########BEDOR ERROR');
    console.log(this.errorPopupConfig.message);
    // console.log('##########FROM ERROR');
    console.log(this.errorPopupConfig.message[0].length);
    this.errorPopup = true;
  },
  _getAllProvince(){
    const newurl = this.url+"province-get-all";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              // console.log(response.data.data);
              this.provinceData = response.data.data;
            })
            .catch(error=>{
              console.log(error);
            })
  },
  _getDistrictByProvince(e){
    const idpro = this.province_id;
    const newurl = this.url+"districts-get-all/"+idpro+"/province";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.districtData = response.data.data;
              // console.log(response.data.data);
            }).catch(error =>{
              console.log(error);
            })
  },
  _getSectorByDistrict(){
    const idDistr = this.district_id;
    const newurl = this.url+"sectors-get-all/"+idDistr+"/district";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.sectorData = response.data.data;
              // console.log(response.data.data);
            }).catch(error =>{
              console.log(error);
            })
  },
  _getCellBySector(){
    const idSector = this.sector_id;
    const newurl = this.url+"cells-get-all/"+idSector+"/sectors";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.cellData = response.data.data;
              // console.log(response.data.data);
            }).catch(error =>{
              console.log(error);
            })
  },
  _getVillageByCell(){
    const idCell = this.cell_id;
    const newurl = this.url+"villages-get-all/"+idCell+"/cells";
    return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.villageData = response.data.data;
              // console.log(response.data.data);
            }).catch(error =>{
              console.log(error);
            })
  },
  _u_fx_to_empty_field(){
    vthis.province_id = "";
    vthis.district_id = "";
    vthis.sector_id = "";
    vthis.cell_id = "";
    vthis.village_id = "";
    vthis.address = "";
    vthis.etage = 0;
    vthis.saloon = 0;
    vthis.bedrooms = 0;
    vthis.bathrooms = 0;
    vthis.toilet = 0;
    vthis.cooked = 0;
    vthis.annexe = 0;
    vthis.waterTank = 0;
    vthis.parking = 0;
    vthis.jardin = 0;
    vthis.surface = 0;
    vthis.price = 0;
    vthis.fully = "";

    //CARS FIELDS
    vthis.mark ="";
    vthis.kilometrage ="";
    vthis.moteur ="";
    vthis.annee_fabrication ="";
    vthis.fuel ="";
    vthis.steeling ="";
    vthis.coleur ="";
    vthis.transimission ="";
    vthis.seating ="";
    vthis.doors ="";
    vthis.engine_size ="";
    vthis.price ="";

    //TENDERS FIELDS

    vthis.title = "";
    vthis.entreprise = "";
    vthis.datapublished = "";
    vthis.deadline = "";
    vthis.linkapply = "";
    vthis.description = "";

    //AUCTIONS $fields
    vthis.lieu ="";
  },
  _u_fx_create_form_data_property(){
    var formData = new FormData();
    if(this.fileMain != null && this.fileListImage.length > 0){
      formData.append('province_id',vthis.province_id);
      formData.append('district_id',vthis.district_id);
      formData.append('sector_id',vthis.sector_id);
      formData.append('cell_id',vthis.cell_id);
      formData.append('village_id',vthis.village_id);
      formData.append('address',vthis.address);
      formData.append('etage',vthis.etage);
      formData.append('saloon',vthis.saloon);
      formData.append('bedrooms',vthis.bedrooms);
      formData.append('bathrooms',vthis.bathrooms);
      formData.append('toilet',vthis.toilet);
      formData.append('cooked',vthis.cooked);
      formData.append('annexe',vthis.annexe);
      formData.append('waterTank',vthis.waterTank);
      formData.append('parking',vthis.parking);
      formData.append('jardin',vthis.jardin);
      formData.append('surface',vthis.surface);
      formData.append('price',vthis.price);
      formData.append('fully',vthis.fully);
      formData.append('main_image', this.fileMain);
      for(var i=0; i< this.fileListImage.length; i++){
  			formData.append('input-file-other[]', vthis.fileListImage[i]);
  		}
      return formData;
    }else{
      return 'errors';
    }
  },
  _u_fx_create_form_data_cars(){
    var formData = new FormData();
    if(this.fileMain != null && this.fileListImage.length > 0){
      formData.append('mark',vthis.mark);
      formData.append('kilometrage',vthis.kilometrage);
      formData.append('moteur',vthis.moteur);
      formData.append('annee_fabrication',vthis.annee_fabrication);
      formData.append('fuel',vthis.fuel);
      formData.append('steeling',vthis.steeling);
      formData.append('coleur',vthis.coleur);
      formData.append('transimission',vthis.transimission);
      formData.append('seating',vthis.seating);
      formData.append('doors',vthis.doors);
      formData.append('engine_size',vthis.engine_size);
      formData.append('price',vthis.price);
      formData.append('main_image', this.fileMain);
      for(var i=0; i< this.fileListImage.length; i++){
        formData.append('input-file-other[]', vthis.fileListImage[i]);
      }
      return formData;
    }else{
      return 'errors';
    }
  },
  _u_fx_create_form_data_tenders(){
    var formData = new FormData();
    if(this.fileMain != null && this.fileListImage.length > 0){
      formData.append('title',vthis.title);
      formData.append('description',vthis.description);
      formData.append('datapublished',vthis.datapublished);
      formData.append('deadline',vthis.deadline);
      formData.append('entreprise',vthis.entreprise);
      formData.append('linkapply',vthis.linkapply);
      formData.append('main_image', this.fileMain);
      for(var i=0; i< this.fileListImage.length; i++){
        formData.append('input-file-other[]', vthis.fileListImage[i]);
      }
      return formData;
    }else{
      return 'errors';
    }
  },
  _u_fx_create_form_data_auctions(){
    var formData = new FormData();
    if(this.fileMain != null && this.fileListImage.length > 0){
      formData.append('title',vthis.title);
      formData.append('description',vthis.description);
      formData.append('datapublished',vthis.datapublished);
      formData.append('deadline',vthis.deadline);
      formData.append('lieu',vthis.entreprise);
      formData.append('main_image', this.fileMain);
      for(var i=0; i< this.fileListImage.length; i++){
        formData.append('input-file-other[]', vthis.fileListImage[i]);
      }
      return formData;
    }else{
      return 'errors';
    }
  },
  _u_fx_to_empty_field_images(){
    this.tabImageHouseUpload = [[0,'uploads/file_static/default-upload.png',false]];
    this.fileMain = null;
    this.fileListImage = [];
    this.avatarMain = 'uploads/file_static/default-upload.png';
    console.log("from image empty");

  },
  _u_fx_to_verify_router(){
    const pth = window.location.pathname.split('/');
    if(pth[1] ==='admin-property.dy' || pth[1] ==='property'){

        this.get_properties();
    }
    if(pth[1] ==='admin-property-detail.dy' || pth[1] ==='property-detail'){
        if(pth[2] !== undefined){
          // return pth[2];
          this.get_properties_detail(pth[2]);
        }

    }
    if(pth[1] ==='admin-cars.dy' || pth[1] ==='cars'){
      this.get_cars();
    }
    if(pth[1] ==='admin-cars-detail.dy' || pth[1] ==='cars-detail'){
        if(pth[2] !== undefined){
          this.get_cars_detail(pth[2]);
        }

    }
    if(pth[1] ==='admin-tenders.dy' || pth[1] ==='tenders'){
      this.get_tenders();
    }
    if(pth[1] ==='admin-tenders-detail.dy' || pth[1] ==='tenders-detail'){
        if(pth[2] !== undefined){
          this.get_tenders_detail(pth[2]);
        }

    }
    if(pth[1] ==='admin-jobs.dy' || pth[1] ==='jobs'){
      this.get_jobs();
    }
    if(pth[1] ==='admin-jobs-detail.dy' || pth[1] ==='jobs-detail'){
        if(pth[2] !== undefined){
          this.get_jobs_detail(pth[2]);
        }

    }
    if(pth[1] ==='admin-auctions.dy' || pth[1] ==='auctions'){
      this.get_auctions();
    }
    if(pth[1] ==='admin-auctions-detail.dy' || pth[1] ==='auctions-detail'){
        if(pth[2] !== undefined){
          this.get_auctions_detail(pth[2]);
        }

    }


  },

  _u_fx_divers_next(){
    this.tabDivers.push(0);
    console.log(this.tabDivers);
    console.log(this.tabDivers.length);
  },
  _u_fx_divers_prev(){
    this.tabDivers.splice(1,1);
  },
  _u_shift_menu(){
    this.MenuShift=!this.MenuShift;
    // localStorage.setItem("menu","true");
    // alert("here");
  }


}
})





// REFERENCES
/*
* CONVERT OBJECT IN ARRAYS
*/
// Object.keys(zoo);
// // ['lion', 'panda']
//
// Object.values(zoo);
// // ['🦁', '🐼']
//
// Object.entries(zoo);
// // [ ['lion', '🦁'], ['panda', '🐼'] ]
