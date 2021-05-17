var vthis = new Vue({
  el : "#app",
  components: {
   vuejsDatepicker
  },
  data () {
    return {
      // urlBase : "",
      url : "",
      indexRoute : "",
      //url : 'http://172.18.0.11/api/v1/',
      tokenConfig : {
        'authorization' : '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627',
        'Content-Type':'multipart/form-data'
      },
      tabListData: [],
      messageError : false,
      errorPopupClass : ['alert','alert-success'],
      errorPopupClassBottom : ['alert','alert-success'],
      messageErrorBottom : false,
      messageAlertConfig :{
        "title":"",
        "message":[],
      },
      messageAlertConfigBottom :{
        "title":"",
        "message":[],
      },
      dataToDisplay : [],
      dataToDisplaySecond : [],
      styleModal : 'none',
      styleModalFaveur : 'none',
      styleModalDetail : 'none',
      display : this.styleModal,
      modalTitle :"",
      dateFilter :null,
      dateFilterDisplay : "D'AUJORD'HUI",

      //  Recherche
      dataToSearch : "",
      RadioCheckedValue : "",
      isParameterAdvanced : 0,
      isResearchPagination : false,

      // //DATA FILTRE
      // attente: 0,
      // payee: 0,
      // livree :0,
      // annuler:0,

      montantCaisse:0,
      codeIdArticlePrint : "",

      //VARIABLE  LOAD BUTTON ACTION
      isShow : false,
      isWantBeDeleted : false,
      isNoQuantity : false,
      isLoadNego : false,
      isLoadDelete : false,
      isLoadNegoAnnuler : false,
      isLoadSaveMainButton : false,
      isLoadSaveMainButtonSecond : false,
      isLoadSaveMainButtonModal : false,
      isDecaissementExterne : false,
      isNoReturnedData : false,

      //SHOW BOOLEAN
      isStockIndicator : false,
      showAdvancedSearch : false,
      isShowLoginMessage : true,

      //VARIABLE LOAD DATE TABLE
      // isDataTableLoad :false,

      //DEFAUL VALEUER
      lastFactureEncodede : "",



      //LIST PARTICULIERES
      depotList : [],
      profileList:[],
      caissierList :[],
      detailTab : [],
      ListFiltreData : [], //POUR MENU LISTE
      checkBoxArticles: [],
      ArticleValidateNego : {},
      CritiqueDataTab:[],
      checkBoxAchatSelected:[],
      checkIsFaveur : [],
      ListIdArticleFaveur : new Array(), //La liste de tous les artilces qui possede une faveur
      ListPricesArticle : new Array(),

      //VARIABLE FORM ADD ARTICLE
      code_article :"",
      nom_article :"",
      poids :"",
      description  :"",
      nombre_piece : 1,
      users_id : localStorage.u,

      //VARIABLE FORM ADD ARTICLE PRIX ARTICLE
      articles_id:"",
      type_prix:"",
      qte_decideur_min:"",
      qte_decideur_max:"",
      prix_unitaire:"",
      price_id : "",

      //VARIABLE ADD COMMANDES PETIT FORMULAIRE ARTICLES
      codeArticle :"",
      qteTotal : 0,
      qtePv : 0,
      qte : 0,

      //VARIABLE CREATE COMMANDE
      numero_commande:"",
      nom_client:"",
      telephone_client: "",
      date_vente:"",
      payer_a : "",

      //VARIABLE FORM APPROVISIONNEMENT
      depots_id :"",
      date_approvisionnement :"",
      plaque : "",
      nom_chauffeur : "",
      num_chauffeur : "",
      num_bordereau : "",

      //VALIDATION PAYEMENT CAISSIER
      password_op : "",
      commande_id :"",
      somme_commande : "",

      //LISTE COMMANDE MAGAZ
      dpot_id : localStorage.dp,
      depot_central_id : "",

      //VARIABLE LOGIQUE FILTRE SUR LISTE ATTENTE, PAYER, LIVRER ADMIN
      stateStatus :"",
      montantTotalAllCommandeParTypeVente : "",
      montantTotalAchat : 0,

      //VARIABLE DEMANDE DECAISSSEMENT
      caissier:"",
      montant_decaisse:"",
      note:"",

      //VARIABLE ACCEPTATION DECAISSEMENT CAISSIER PRINCIPAL
      decaissement_id :"",

      //VARIABLE DECAISSEMENT EXTERNE
      destination:"",
      montant:"",

      //VARIABLE AJOUT DEPOTS
      nom :"",
      responsable_id : "",
      adresse :"",

      //  VARIABLE
      montant_max:"",
      montant_min:"",

      //PAGINATION
      pageNumber:0,
      paginationTab:[],
      paginationTabIn:{},
      currentIndexPage :0,
      PerPaged:5,
      totalData : 0,

      //VARIABLE CREATION UTILISATEUR
      nom :"",
      prenom :"",
      RadioCheckedSexe :"",
      tel :"",
      roles_id :"",
      dob :"",
      depot_id :"",
      date_debut_service :"",
      RadioCheckedIsMain :"",
      username :"",
      password_main :"",
      password_main_conf :"",
      password_op :"",
      password_op_conf :"",
      ancien_password_main : "",
      ancien_password_op : "",


      avatarMain:"",
      fileMain :"",
      iduserToChangeProfile :"",

      //LOGIQUE SHOW OR HIDDEN BUTON SAVE AND UPDATE CONFIG PRICE ARTICLE,
      isAction : true,
      isShowBlocHistoFactureStatus : false,
      isActionFaveur : true,

      //SI CE DEPOT A DEJA LIVRER UNE PARTIE DE LA COMMANDE
      hasAlreadyDelivered : false,

      //CREATE CONFIGURATION FAVEUR ARTICLE
      prix_id : "",
      qte_faveur : "",
      prix_id_saved : "",// for UPDATE
      config_faveur_id : "",  // for UPDATE

      //CREATE ENCAISSEMENT EXTERNE
      montant_encaissement : "",
      motif : "",
      montantTotalAllEncaissement : "",

      //PV RESTAURE ET APPROVISIOONER
      qte_restaurer : "",
      qte_restaurer_init : "",
      qte_perdue : 0,
      qte_pv_kg : 0,
      poids_article : 0,
      qte_pv_kg_up : 0, //uniquement pour la partie update


      //SLECTIONNER LIGNE QUI EST VISIBLE
      currentLineSelectedInList : -1,


      //RAPPORT
      dateRapport : "",
      dateRapportFin : "",
      dateRapportGen : "",
      dateRapportDebut : "",
      dateRapportEnd : "",
      dateRapportDebutAppro : "",
      dateRapportEndAppro : "",

      //VARIVALE POUR DROIT ACCESS
      accessGestionPv : "",


      //STATUS FOR UPDATED
      wantToUpdate : false,
      indexTopUpdate : null,
      idElementSelected : null,

      //validation Action Livraison Partielle
      isPartielle : false,
      isPartielFecthData : 0,

      //Config Syst
      textDescriptif : null,
      typeAction : null,
      passIsCorrectCanProcceed : false,

      //AJUSTEMENT STOCK VIRTUELLE ET REEL DEPOT
      qte_reelle : 0,
      qte_virtuelle : 0,

      //TRANSFERT
      usersListParDepot : [],
      usersDestTransfert : null,
      date_transfert: "",
      idStockPerso : "", //Lors de l'ajustement stock
      isLinkToLoadUserDepot : false,

      //MOTIF DECAISSEMENT GET
      ListMotifDecaissement : [],
      nom_motif_decaissement : "",

      montantTotatAllDecaissement : 0,
      disabledDate : {
        ranges : [
          { // Disable dates in given ranges (exclusive).
              from: new Date(1970, 0, 1),
              to: new Date(this.dateFilter)
            }
        ]
      },
      MotifDecaissementStatus : null,

      //CLIENTS OPERATIONS
      nom_client_ab : "",
      prenom_client_ab : "",
      tel_client_ab : "",
      adresse_client_ab : "",

      //POUR CREDITER CLIENS
      montant_actuel_client : 0,
      montant_a_crediter_client : 0,


      isInterval : 0,
      depot_id_in : "",
      depot_id_in_app : "",

      detailOperationAretirer : null,
      QteTotalOperationDejaRetirer : 0,

      isGettingAretire : 0,
      idUserToGetHistoPv : null,


    }
  },

  created () {
    this._u_set_base_url();
    this._u_fx_to_load_router();
    this._u_get_code_facture();
    this._u_get_today();
    this._u_fx_get_montant();


  },
  methods : {
    add_article(e){
    e.preventDefault();
    const newurl = this.url+"articles-create-one";
    var form = this._u_fx_form_data_art();
    this.messageError = false;
    this.isLoadSaveMainButtonModal = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_article();
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_article(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"articles-get-all/"+limit+"/"+offset;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              this.isShow = false;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_article_prix(e){
      e.preventDefault();
      const newurl = this.url+"articles-create-price";
      var form = this._u_fx_form_data_art_price();
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this.get_article();
                  this.isLoadSaveMainButtonModal = false;
                  this._u_close_mod_form();
                  this.isShow = false;
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButtonModal = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    add_commande(e){
      e.preventDefault();
      const newurl = this.url+"/commandes-create";
      var form = new FormData();
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      form.append('numero_commande',this.numero_commande);
      form.append('nom_client',this.nom_client);
      form.append('date_vente',this.date_vente);
      form.append('users_id',this.users_id);
      form.append('status_vente_id',1);
      form.append('depots_id',this.depots_id);
      form.append('payer_a',this.payer_a);
      form.append('telephone_client', this.telephone_client);
      form.append('container_faveur',this.ListIdArticleFaveur.length > 0 ? 1 : 0);
      form.append('depots_id_faveur', this.depot_central_id);
      form.append('is_livrer_all', 0);

      for(var i=0; i< this.tabListData.length; i++){
        form.append('articles_id[]', this.tabListData[i]['id']);
        form.append('qte_vendue[]', this.tabListData[i]['qte']);
        form.append('prix_unitaire[]', this.tabListData[i]['prix_unit']);
				form.append('type_prix[]', this.tabListData[i]['type_id']);
        form.append('is_faveur[]', this.tabListData[i]['isfaveur']);
			}
      if(this.tabListData.length < 1){
        this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
        this.isLoadSaveMainButton = false;
        return;
      }

      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_get_code_facture();
                  this._u_get_last_achat_facturier();
                  this.tabListData=[];
                  this.nom_client = "";
                  this.telephone_client = "";
                  this.depots_id = "";
                  this.payer_a = "";
                  this.isLoadSaveMainButton = false;
                  this.checkIsFaveur = new Array();
                  this.ListIdArticleFaveur = new Array();
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_depots(){
      const newurl = this.url+"depot-get-all";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.depotList = response.data.data;
              if(this.depotList.length < 1){
                this.isNoReturnedData = true;
              }
            }).catch(error =>{
              console.log(error);
            })
    },
    get_profiles(){
      const newurl = this.url+"roles-get-all";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.profileList = response.data.data;
              // console.log(this.depotList);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_caissiers(){
      const newurl = this.url+"users-get-all/3/profile";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.caissierList = response.data.data;
              this.montantTotalAllCommandeParTypeVente = response.data.montantAllCaissier;

              if(this.caissierList.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    get_caissiers_main_and_admin(){
      const newurl = this.url+"users-get-all-caissier-main-and-admin";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.caissierList = response.data.data;
              // this.montantTotalAllCommandeParTypeVente = response.data.montantAllCaissier;

              if(this.caissierList.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    add_approvision(e){
      e.preventDefault();
      const newurl = this.url+"approvisionnement-create";
      var form = new FormData();
      form.append('date_approvisionnement',this.date_approvisionnement);
      form.append('depots_id',this.dpot_id);
      form.append('users_id',this.users_id);
      form.append('plaque_vehicule',this.plaque);
      form.append('nom_chauffeur',this.nom_chauffeur);
      form.append('telephone_chauffeur',this.num_chauffeur);
      form.append('numero_bordereau',this.num_bordereau);
        for(var i=0; i< this.tabListData.length; i++){
          console.log(this.tabListData[i].qtea);
          form.append('articles_id[]', this.tabListData[i].info[0].id);
          form.append('qte[]', this.tabListData[i].qtea);
          form.append('qte_total[]', this.tabListData[i].qteTotal);
          form.append('qte_pv[]', this.tabListData[i].qtePv);
  			}
        if(this.tabListData.length < 1){
          this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
          return;
        }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_commande_facturier(statut=1,limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/"+this.dateFilter+"/"+limit+"/"+offset+"/facturier";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_reset_checkBoxSelected();
              //CREATION PAGINATION
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this.isResearchPagination = false;
              this._u_fx_generate_pagination(response.data.all);


            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_caissier(statut=1,limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/"+this.dateFilter+"/"+limit+"/"+offset+"/caissier";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_fx_get_montant();
              //CREATION PAGINATION
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this.isResearchPagination = false;
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validation_payement(){
      const newurl = this.url+"commandes-validation-caissier/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/"+this.somme_commande+"/validation";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_caissier(1);
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              if(response.data.status==401){
                  this.get_commande_caissier(1);
              }
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_magazinier(statut=2,limit=this.PerPaged,offset=0, indexPage=0,isPartiel=this.isPartielFecthData, isAretirer = this.isGettingAretire){
      const newurl = this.url+"commandes-get-by-depot/"+this.dpot_id+"/"+statut+"/"+this.dateFilter+"/"+limit+"/"+offset+"/"+isPartiel+"/"+isAretirer+"/depot";
      this.stateStatus = statut;
      // alert(this.isPartielFecthData);
      // alert(this.dateFilter);
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_reset_checkBoxSelected();
              // console.log(this.dataToDisplay);
              //CREATION PAGINATION
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this.isResearchPagination = false;
              this._u_fx_generate_pagination(response.data.all);

              console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_faveur_magazinier(statut=2){
      const newurl = this.url+"commandes-faveur-get-by-depot/"+this.dpot_id+"/"+statut+"/"+this.dateFilter+"/depot";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_reset_checkBoxSelected();
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validation_livraison(from){ //from : 1 faveur ou 2 achat normal
      const newurl = this.url+"commandes-validation-magaz/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/"+this.dpot_id+"/validation";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                if(from == 1){
                  this.get_commande_faveur_magazinier(2);
                }else {
                  if(this.isPartielFecthData ==0){
                    this.get_commande_magazinier(2);
                  }else{
                    this.get_commande_magazinier(3);
                  }

                }

                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_admin(statut=1,limit=this.PerPaged,offset=0, indexPage=0,isPartiel=this.isPartielFecthData){
      const newurl = this.url+"commandes-all-by-status/"+statut+"/"+this.dateFilter+"/"+limit+"/"+offset+"/"+isPartiel+"/status";
      this.stateStatus = statut;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.montantTotalAllCommandeParTypeVente = response.data.sommesTotalAllCommandes;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              //CREATION PAGINATION
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this.isResearchPagination = false;
              this._u_fx_generate_pagination(response.data.all);
              console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_ask_negotiation(cmd){
      this.isLoadNego = true;
      const newurl = this.url+"demande-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_facturier(1);
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_attente_negotiation(statutNegotiation=1){
      const newurl = this.url+"achat-get-all-negotiation/"+statutNegotiation+"/negotiation";
      this.stateStatus = statutNegotiation;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteTypeNegotiation;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validate_negotiation(cmd){
      this.isLoadNego = true;
      console.log(this.ArticleValidateNego);
      const newurl = this.url+"achat-validate-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      form.append('idcaissier',this.payer_a);
      if(this.payer_a ==""){
        this._u_fx_config_error_message_bottom("Message",['Vous devez choisir le caissier'],'alert-danger');
        this.isLoadNego = false;
        return;
      }

      if(Object.keys(this.ArticleValidateNego).length < 1){
        this._u_fx_config_error_message_bottom("Message",['Veuillez prédefinir le montant de reduction'],'alert-danger');
        this.isLoadNego = false;
        return;
      }
      this.messageError = false;
      for(key in this.ArticleValidateNego){
          form.append('idarticle[]', this.ArticleValidateNego[key][0]);
          form.append('montant[]', this.ArticleValidateNego[key][1]);
    	}
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(2);
                this.payer_a ="";
                this.ArticleValidateNego = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;

            }).catch(error =>{
              console.log(error);
            })
    },
    add_annuler_tout_validate_negotiation(cmd){
      this.isLoadNegoAnnuler = true;
      const newurl = this.url+"achat-annuler-tout-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNegoAnnuler = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(1);
                this.ArticleValidateNego = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNegoAnnuler = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_annuler_validate_negotiation_selectionneer(cmd){
      this.isLoadNegoAnnuler = true;
      const newurl = this.url+"achat-annuler-selection-negotiation";
      var form = new FormData();
      form.append('idcommande',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNegoAnnuler = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_attente_negotiation(2);
                this.checkBoxArticles = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNegoAnnuler = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_caissier_main(){
      const newurl = this.url+"users-get-all-is-main-by-profile/3/1/is-main";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.caissierList = response.data.data;
              // console.log(this.caissierList);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_decaissement_demande(e){
    e.preventDefault();
    const newurl = this.url+"create-decaissement-solde";
    var form = this._u_fx_form_data_decaissement();
    this.isLoadSaveMainButton = true;
    this.messageError = false;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_decaisssement_caissier_secondaire();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_decaisssement_caissier_secondaire(){
    const newurl = this.url+"get-decaissement-par-caissier/"+this.users_id;
    this.dataToDisplay = [];
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            if(this.dataToDisplay.length < 1){
              this.isNoReturnedData = true;
            }
          }).catch(error =>{
            console.log(error);
          })
        },
    /*Fx POUR LISTE DE DEMANDES DE DECAISSEMENT COTE CAISSIER PRINCIPAL*/
    get_decaisssement_caissier_principale(status=2){
    if(this.dateFilter !==null){
      this._u_formatOnlyDate();
    }
    const newurl = this.url+"get-all-decaissement/"+this.users_id+"/"+status+"/"+this.dateFilter+"/decaisse";
    this.stateStatus = status;
    this.dataToDisplay =[];
    this.isNoReturnedData = false;
    this.isDecaissementExterne = false;
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{

            this.dataToDisplay = response.data.data;
            if(this.dataToDisplay.length < 1){
              this.isNoReturnedData = true;
            }
            this._u_fx_get_montant();
          }).catch(error =>{
            console.log(error);
          })
        },
    get_decaisssement_histo_interne_admin(status=2){
        if(this.dateFilter !==null){
          this._u_formatOnlyDate();
        }
        const newurl = this.url+"get-all-decaissement/0/"+status+"/"+this.dateFilter+"/decaisse";
        this.stateStatus = status;
        this.dataToDisplay =[];
        this.isNoReturnedData = false;
        this.isDecaissementExterne = false;
        return axios
              .get(newurl,{headers: this.tokenConfig})
              .then(response =>{

                this.dataToDisplay = response.data.data;
                if(this.dataToDisplay.length < 1){
                  this.isNoReturnedData = true;
                }
                this._u_fx_get_montant();
              }).catch(error =>{
                console.log(error);
              })
            },
    /*Fx POUR VALIDATION DECAISSEMENT COTE CAISSIER PRINCIPAL*/
    add_validation_decaissement(){
      const newurl = this.url+"validation-decaissement/"+this.decaissement_id+"/"+this.users_id+"/"+this.password_op+"/validate";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_decaisssement_caissier_principale();
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_decaissement_externe(e){
    e.preventDefault();
    const newurl = this.url+"create-decaissement--solde-externe";
    var form = this._u_fx_form_data_decaissement_externe();
    // console.log(this.montant);
    if(this.montant ==""){
      this._u_fx_config_error_message_bottom("Message",['Le montant est obligatoire'],'alert-danger');
      return;
    }
    this.messageError = false;
    this.isLoadSaveMainButton = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.destination = 0;
                this.get_decaisssement_externe();
                this._u_fx_get_montant();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_decaisssement_externe(NoVariable=null,limit=this.PerPaged,offset=0, indexPage=0){
      let isInterval = this.checkBoxArticles.length > 0 ? 1 : 0;
      const newurl = this.url+"get-decaissement-externe-par-caissier/"+this.users_id+"/"+this.destination+"/"+this.dateFilter+"/"+this.dateFilterEnd+"/"+isInterval+"/"+limit+"/"+offset;
      this.tabListData =[];
      this.isNoReturnedData = false;
      this.isDecaissementExterne = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.tabListData = response.data.data;
              this.montantTotatAllDecaissement = response.data.montantTotalDecaissement;
              // console.log(response.data.montantTotalDecaissement);
              if(this.tabListData.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_fx_get_montant();

              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);

            }).catch(error =>{
              console.log(error);
            })
    },
    get_decaisssement_externe_admin(NoVariable=null,limit=this.PerPaged,offset=0, indexPage=0){
      let isInterval = this.checkBoxArticles.length > 0 ? 1 : 0;
      const newurl = this.url+"get-decaissement-externe-par-caissier/0/"+this.destination+"/"+this.dateFilter+"/"+this.dateFilterEnd+"/"+isInterval+"/"+limit+"/"+offset;
      this.tabListData =[];
      this.isNoReturnedData = false;
      this.isDecaissementExterne = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.tabListData = response.data.data;
              this.montantTotatAllDecaissement = response.data.montantTotalDecaissement;
              if(this.tabListData.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);

              this._u_fx_get_montant();
            }).catch(error =>{
              console.log(error);
            })
    },
    update_article_prix(e){
      e.preventDefault();
      const newurl = this.url+"articles-update-price";
      var form = this._u_fx_form_data_art_price();
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_close_mod_form();
                  this.get_article();
                  this.isLoadSaveMainButtonModal = false;
                  return;
                }
                var err = response.data.message.errors;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_historique_approvisionnement(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-get-all/"+this.dateFilter+"/"+limit+"/"+offset;
      this.isNoReturnedData = false;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      //Reset la partie selected coloree
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
              // console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_historique_approvisionnement_by_depot(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-get-by-depot/"+this.dpot_id+"/"+limit+"/"+offset+"/"+this.dateFilter;
      this.isNoReturnedData = false;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_stock_depots(){
    const newurl = this.url+"stock-depot";
    if(this.isShow){
      this.isShow = !this.isShow;
    }
    this.dataToDisplay=[];
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            this.CritiqueDataTab = response.data.critique;
            console.log(this.CritiqueDataTab[0].montant_min);
          }).catch(error =>{
            console.log(error);
          })
        },
    add_depot(e){
    e.preventDefault();
    this.isLoadSaveMainButton = true;
    const newurl = this.url+"depot-create-one";
    var form = this._u_fx_form_data_depot();
    this.messageError = false;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_depots();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this.isLoadSaveMainButton = false;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
          })
          .catch(error =>{
            console.log(error);
          })
        },
    get_stock_depots_by_depot(){
    const newurl = this.url+"stock-depot-by-depot/"+this.dpot_id+"/depot";
    this.dataToDisplay=[];
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            this.CritiqueDataTab = response.data.critique;
            // console.log(this.dataToDisplay);
          }).catch(error =>{
            console.log(error);
          })
        },
    get_configuration_etat_critique(){
      const newurl = this.url+"etat-critique";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              // console.log(this.dataToDisplay);
              this.montant_max = this.dataToDisplay[0].montant_max;
              this.montant_min = this.dataToDisplay[0].montant_min;
            }).catch(error =>{
              console.log(error);
            })
    },
    update_etat_critique_config(e){
    e.preventDefault();
    this.isLoadSaveMainButton = true;
    const newurl = this.url+"update-etat-critique";
    var form = {
      "montant_min":this.montant_min,
      "montant_max":this.montant_max
    }
    this.messageError = false;
    return axios
          .put(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_configuration_etat_critique();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this.isLoadSaveMainButton = false;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
          })
          .catch(error =>{
            console.log(error);
          })
  },
    add_annuler_achat(){
      const newurl = this.url+"achat-annuler";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      var form = new FormData();
      form.append('pwd',this.password_op);
      form.append('iduser',this.users_id);
      for(var i=0; i< this.checkBoxAchatSelected.length; i++){
        form.append('idcommande[]', this.checkBoxAchatSelected[i]);
    	}
      this.isLoadSaveMainButtonModal = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_facturier(1);
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                this.checkBoxAchatSelected = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_users(e){
      e.preventDefault();
      const newurl = this.url+"users-create-one";
      var form = this._u_fx_form_data_users();
      if(this.password_main != this.password_main_conf){
        this._u_fx_config_error_message("Erreur",["Les 2 mots de passe principal ne corresondent pas"],'alert-danger');
        return;
      }
      if(this.password_op != this.password_op_conf){
        this._u_fx_config_error_message("Erreur",["Les 2 mots de passe des opérations ne corresondent pas"],'alert-danger');
        return;
      }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_users_admin(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"users-get-all/"+limit+"/"+offset;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
              console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
            }).catch(error =>{
              console.log(error);
            })
    },
    update_status_account_users(iduser){
      // console.log(iduser);
      const newurl = this.url+"users-update-status-account/"+iduser;
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_users_admin();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    reset_password_account_users(iduser){
      // console.log(iduser);
      const newurl = this.url+"users-reset-password/"+iduser;
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_users_admin();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    update_image_profile(){
      this.isLoadSaveMainButtonModal = true;
      const newurl = this.url+"users-update-profile";
      var form = new FormData();

      form.append('iduser',this.iduserToChangeProfile);
      form.append('main_image', this.fileMain);
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_users_admin();
                this._u_close_mod_form();
                return;
              }
              var err = response.data.message.errors;
              this._u_close_mod_form();
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    delete_article_commande(cmd){
      this.isLoadDelete = true;
      const newurl = this.url+"delete-article-commande";
      var form = new FormData();
      form.append('idcommande',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadDelete = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_facturier(1);
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadDelete = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_approvision_inter_depot(e){
      e.preventDefault();
      const newurl = this.url+"approvisionnement-inter-depot-create";
      var form = new FormData();
      form.append('date_approvisionnement',this.date_approvisionnement);
      form.append('depots_id_source',this.dpot_id);
      form.append('depots_id_dest',this.depots_id);
      form.append('users_id',this.users_id);
      form.append('status_operation',0);

        for(var i=0; i< this.tabListData.length; i++){
          form.append('articles_id[]', this.tabListData[i]['id']);
          form.append('qte[]', this.tabListData[i]['qte']);
  			}
        if(this.tabListData.length < 1){
          this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
          return;
        }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_historique_approvisionnement_inter_depot_by_depot(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-inter-depot-get-by-depot/"+this.dpot_id+"/"+limit+"/"+offset+"/"+this.dateFilter;
      this.isNoReturnedData = false;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(response.data);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_historique_approvisionnement_inter_depot_admin(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-inter-depot-get-all/"+limit+"/"+offset+"/"+this.dateFilter;
      this.dataToDisplay=[];
      this.isNoReturnedData = false;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },

    delete_article_price(){
      this.isLoadDelete = true;
      const newurl = this.url+"articles-delete-price/"+this.price_id+"/del";
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadDelete = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_article();
                this._u_close_mod_form();
                this.isWantBeDeleted = false;
                this.isShow = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadDelete = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_article_config_faveur(e){
      e.preventDefault();
      const newurl = this.url+"articles-create-config-faveur";
      var form = this._u_fx_form_data_art_config_faveur();
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this.get_article();
                  this.isLoadSaveMainButtonModal = false;
                  this._u_close_mod_form();
                  this.isShow = false;
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButtonModal = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    udpate_article_config_faveur(e){
      e.preventDefault();
      const newurl = this.url+"articles-update-configuration-faveur";
      var form = this._u_fx_form_data_art_config_faveur();
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this.get_article();
                  this.isLoadSaveMainButtonModal = false;
                  this._u_close_mod_form();
                  this.isShow = false;
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButtonModal = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },

    change_password_account_users_connexion(){
      // console.log(iduser);
      const newurl = this.url+"users-reset-password-connexion/"+this.users_id+"/"+this.ancien_password_main+"/"+this.password_main+"/update";
      if(this.password_main != this.password_main_conf){
        this._u_fx_config_error_message("Erreur",["Les 2 nouveaux mot de passes doivent correspondre"],'alert-danger');
        return;
      }
      if(this.password_main =="" || this.password_main_conf == "" || this.ancien_password_main == ""){
        this._u_fx_config_error_message("Erreur",["Tous les champs sont obligatoire"],'alert-danger');
        return;
      }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_users_admin();
                  this._u_fx_form_init_field();
                  this.isLoadSaveMainButton = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    change_password_account_users_operations(){
      // console.log(iduser);
      const newurl = this.url+"users-reset-password-operation/"+this.users_id+"/"+this.ancien_password_op+"/"+this.password_op+"/update";
      if(this.password_op != this.password_op_conf){
        this._u_fx_config_error_message("Erreur",["Les 2 nouveaux mot de passes des opérations doivent correspondre"],'alert-danger');
        return;
      }
      if(this.password_op =="" || this.password_op_conf == "" || this.ancien_password_op == ""){
        this._u_fx_config_error_message("Erreur",["Tous les champs sont obligatoire"],'alert-danger');
        return;
      }
      this.isLoadSaveMainButtonModal = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_users_admin();
                  this._u_fx_form_init_field();
                  this.isLoadSaveMainButtonModal = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButtonModal = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    add_encaissement_externe(e){
    e.preventDefault();
    const newurl = this.url+"create-encaissement-externe";
    var form = this._u_fx_form_data_encaissement_externe();
    // console.log(this.montant);
    if(this.montant_encaissement ==""){
      this._u_fx_config_error_message_bottom("Message",['Le montant est obligatoire'],'alert-danger');
      return;
    }
    this.messageError = false;
    this.isLoadSaveMainButton = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_encaisssement_externe(1);
                this._u_fx_get_montant();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_encaisssement_externe(users=null){
    if(this.dateFilter !==null){
      this._u_formatOnlyDate();
    }
    var u = !users? 0 : this.users_id;
    // this.stateStatus = users;
    // console.log(this.stateStatus);
    // console.log(u);
    const newurl = this.url+"get-all-encaissement-externe/"+u+"/"+this.dateFilter+"/enc";
    // this.stateStatus = status;
    this.dataToDisplay =[];
    this.isNoReturnedData = false;
    this.isDecaissementExterne = false;
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{

            this.dataToDisplay = response.data.data;
            if(this.dataToDisplay.length < 1){
              this.isNoReturnedData = true;
            }
            this._u_fx_get_montant();
            this.montantTotalAllEncaissement = response.data.sommeEncaissement;
            // console.log(this.dataToDisplay);
          }).catch(error =>{
            console.log(error);
          })
        },

    add_validation_appro_inter_depot(){ //from : 1 faveur ou 2 achat normal
      const newurl = this.url+"approvisionnement-inter-depot-validate/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/validate";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_approvisionnement_inter_depot_by_depot();
                // if(from == 1){
                //   this.get_commande_faveur_magazinier(2);
                // }else {
                //   this.get_commande_magazinier(2);
                // }

              this._u_close_mod_form();
              this.password_op= "";
              this.isLoadSaveMainButtonModal = false;
              return;
            }
            var err = response.data.message.errors;
            this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            this.isLoadSaveMainButtonModal = false;
          }).catch(error =>{
            console.log(error);
          })
  },
    add_annuler_approvisionnement(){
      const newurl = this.url+"approvisionnement-annuler";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      var form = new FormData();
      form.append('pwd',this.password_op);
      form.append('iduser',this.users_id);
      for(var i=0; i< this.checkBoxAchatSelected.length; i++){
        form.append('idappro[]', this.checkBoxAchatSelected[i]);
      }
      this.isLoadSaveMainButtonModal = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_approvisionnement_inter_depot_by_depot();
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                this.checkBoxAchatSelected = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    delete_article_approvisionnement_inter_depot(cmd){
      this.isLoadDelete = true;
      const newurl = this.url+"delete-article-approvisionnement";
      var form = new FormData();
      form.append('idappro',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadDelete = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_approvisionnement_inter_depot_by_depot();
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadDelete = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    add_approvision_pv_restaure(e){

      e.preventDefault();
      const newurl = this.url+"pv-approvisionnement-restaure";
      var form = new FormData();
      var qtPVKg = Math.floor(this.qte_restaurer) * this.poids_article;

      form.append('users_id',this.users_id);
      form.append('articles_id',this.articles_id);
      form.append('qte_restaure', Math.floor(this.qte_restaurer));
      form.append('qte_perdue', this.qte_perdue);
      form.append('pv_en_kg',qtPVKg);
      form.append('depots_id_dest',this.depots_id);
      form.append('magaz_dest_id',this.usersDestTransfert);
      form.append('date_restaurer',this.date_approvisionnement);

      if(this.qte_restaurer_init < 1){
        this._u_fx_config_error_message("Erreur",["La quantité en unité à restaurer doit être au moins superieure ou égale à 1"],'alert-danger');
        return;
      }


      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this._u_close_mod_form();
                  this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    active_article_visibilite_sur_rapport(idarticle){
      // console.log(iduser);
      const newurl = this.url+"article-change-visibilite-sur-rapport/"+idarticle;
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_article();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },

    validate_partiel_article_approvisionnement_inter_depot(cmd){
      this.isLoadNego = true;
      const newurl = this.url+"validate-partiel-article-approvisionnement";
      var form = new FormData();
      form.append('idappro',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_approvisionnement_inter_depot_by_depot();
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    update_article_kg_pv(){
      this.isLoadSaveMainButtonModal = true;
      const newurl = this.url+"articles-set-kg-pv";
      var form = new FormData();
      form.append('idarticle',this.articles_id);
      form.append('kg',this.qte_pv_kg);
      if(this.qte_pv_kg < 1){
        this._u_fx_config_error_message("Erreur",["Le Kg de PV ne doit pas être inferieur à 1"],'alert-danger');
        return;
      }

      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_close_mod_form();
                this.get_article();
                this.qte_pv_kg = 0;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    update_article_data(e){
    e.preventDefault();
    this.isLoadSaveMainButton = true;
    const newurl = this.url+"update-article/"+this.idElementSelected+"/update";
    var form = {
        "nom_article":this.nom_article,
        "poids": this.poids,
        "description":this.description,
        "nombre_piece":this.nombre_piece,
        "qte_stock_pv":this.qte_restaurer,
        "pv_en_kg": this.qte_pv_kg_up
      }

    this.messageError = false;
    return axios
          .put(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.wantToUpdate = false;
                this.indexTopUpdate = null;
                this.get_article();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this.isLoadSaveMainButton = false;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
          })
          .catch(error =>{
            console.log(error);
          })
  },

    add_validation_livraison_partielle(){

      const newurl = this.url+"commandes-validation-magaz-partielle";
      var form = new FormData();
      form.append('pwd',this.password_op);
      form.append('idcommande',this.commande_id);
      form.append('iduser',this.users_id);
      form.append('iddepot',this.dpot_id);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
      }
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                // alert(this.isPartielFecthData);
                if(this.isPartielFecthData ==0){
                  this.get_commande_magazinier(2);
                }else{
                  this.get_commande_magazinier(3);
                }
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    operation_systeme_config(type){
      let newurl = null;
      if(type==1){
       newurl = this.url+"cloture-stock-journalier";
     }else if(type ==2){
        newurl = this.url+"cloture-caisse-journalier";
     }else if(type ==3){
         newurl = this.url+"users-debloque-account";
     }else if(type ==4){
        newurl = this.url+"users-bloque-account";
     }
      this.messageError = false;
      this.isLoadSaveMainButton = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.isLoadSaveMainButton = false;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_close_mod_form();
                  this.get_etat_parametre_systeme();
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
                this._u_close_mod_form();
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_etat_parametre_systeme(){
    const newurl = this.url+"detect-etat-param-system";
    this.dataToDisplay=[];
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            console.log(this.dataToDisplay);
          }).catch(error =>{
            console.log(error);
          })
        },

    ajustement_stock_depot_virtuel_reel(){
          const newurl = this.url+"ajustement-stock-depot-virtuelle-reelle/"+this.articles_id+"/"+this.depots_id+"/"+this.qte_reelle+"/"+this.qte_virtuelle;

          this.isLoadSaveMainButton = true;
          this.messageError = false;
          return axios
                .get(newurl,{headers: this.tokenConfig})
                .then(response =>{
                    if(response.data.message.success !=null){
                      var err = response.data.message.success;
                      this._u_fx_config_error_message("Succès",[err],'alert-success');
                      this.get_stock_depots();
                      this._u_close_mod_form();
                      this.isLoadSaveMainButton = false;
                      // this.tabListData=[];
                      return;
                    }
                    var err = response.data.message.errors;
                    this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                    this.isLoadSaveMainButton = false;
                })
                .catch(error =>{
                  console.log(error);
                })
        },
    get_magasinier_by_depot(depotID = this.dpot_id){
      const newurl = this.url+"users-get-magaz-by-depot/"+depotID;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.usersListParDepot = response.data.data;

            }).catch(error =>{
              console.log(error);
            })
    },

    add_transfert(e){
      e.preventDefault();
      const newurl = this.url+"transfert-create";
      var form = new FormData();
      form.append('date_transfert',this.date_approvisionnement);
      form.append('users_id_source',this.users_id);
      form.append('users_id_dest',this.usersDestTransfert);
      form.append('users_id',this.users_id);
      form.append('status_operation',0);

      for(var i=0; i< this.tabListData.length; i++){
        form.append('articles_id[]', this.tabListData[i]['id']);
        form.append('qte[]', this.tabListData[i]['qte']);
			}
      if(this.tabListData.length < 1){
        this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
        return;
      }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_historique_transfert_magaz_by_magaz(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"transfert-magaz-get-by-magaz/"+this.users_id+"/"+limit+"/"+offset+"/"+this.dateFilter;
      this.isNoReturnedData = false;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_validation_transfert(){ //from : 1 faveur ou 2 achat normal
      const newurl = this.url+"transfert-validate/"+this.password_op+"/"+this.commande_id+"/"+this.users_id+"/validate";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_transfert_magaz_by_magaz();
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                return;
            }
            var err = response.data.message.errors;
            this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            this.isLoadSaveMainButtonModal = false;
          }).catch(error =>{
            console.log(error);
          })
  },
    add_annuler_transfert(){
      const newurl = this.url+"transfert-annuler";
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      var form = new FormData();
      form.append('pwd',this.password_op);
      form.append('iduser',this.users_id);
      for(var i=0; i< this.checkBoxAchatSelected.length; i++){
        form.append('idtransfert[]', this.checkBoxAchatSelected[i]);
      }
      this.isLoadSaveMainButtonModal = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_transfert_magaz_by_magaz();
                this._u_close_mod_form();
                this.password_op= "";
                this.isLoadSaveMainButtonModal = false;
                this.checkBoxAchatSelected = [];
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    delete_article_transfert(cmd){
      this.isLoadDelete = true;
      const newurl = this.url+"delete-article-transfert";
      var form = new FormData();
      form.append('idtransfert',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadDelete = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_transfert_magaz_by_magaz();
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadDelete = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    validate_partiel_article_transfert(cmd){
      this.isLoadNego = true;
      const newurl = this.url+"validate-partiel-article-transfert";
      var form = new FormData();
      form.append('idtransfert',cmd);
      for(var i=0; i< this.checkBoxArticles.length; i++){
        form.append('idarticle[]', this.checkBoxArticles[i]);
    	}
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadNego = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_historique_transfert_magaz_by_magaz();
                this._u_close_mod_form();
                this._u_reset_checkBoxSelected();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadNego = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_historique_transfert_admin(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"transfert-get-all/"+limit+"/"+offset+"/"+this.dateFilter;
      this.dataToDisplay=[];
      this.isNoReturnedData = false;
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_stock_personnel_par_magaz(){
    const newurl = this.url+"stock-personnel-magaz/"+this.users_id;
    this.dataToDisplay=[];
    this.isNoReturnedData = false;
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            // this.CritiqueDataTab = response.data.critique;
            if(this.dataToDisplay.length < 1){
              this.isNoReturnedData = true;
            }
            console.log(this.dataToDisplay);
          }).catch(error =>{
            console.log(error);
          })
        },
    get_stock_personnel_admin(){
    const newurl = this.url+"stock-personnel-get-all";
    if(this.isShow){
      this.isShow = !this.isShow;
    }
    this.dataToDisplay=[];
    return axios
          .get(newurl,{headers: this.tokenConfig})
          .then(response =>{
            this.dataToDisplay = response.data.data;
            // this.CritiqueDataTab = response.data.critique;
            console.log(this.dataToDisplay);
          }).catch(error =>{
            console.log(error);
          })
        },
    ajustement_stock_personnel(){
          const newurl = this.url+"stock-personnel-ajustement/"+this.idStockPerso+"/"+this.qte_reelle;

          this.isLoadSaveMainButton = true;
          this.messageError = false;
          return axios
                .get(newurl,{headers: this.tokenConfig})
                .then(response =>{
                    if(response.data.message.success !=null){
                      var err = response.data.message.success;
                      this._u_fx_config_error_message("Succès",[err],'alert-success');
                      this.get_stock_personnel_admin();
                      this._u_close_mod_form();
                      this.isLoadSaveMainButton = false;
                      // this.tabListData=[];
                      return;
                    }
                    var err = response.data.message.errors;
                    this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                    this.isLoadSaveMainButton = false;
                })
                .catch(error =>{
                  console.log(error);
                })
        },

    get_destination_motif_decaissement(){
      const newurl = this.url+"motif-decaissement-get-all";
      this.ListMotifDecaissement = [];
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.ListMotifDecaissement = response.data.data;
              if(this.ListMotifDecaissement.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    add_motif_destination_decaissement(){
      const newurl = this.url+"motif-decaissement-create-one";
      var form = new FormData();
      form.append('description',this.nom_motif_decaissement);
      form.append('is_active',1);

      this.isLoadSaveMainButtonModal = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_destination_motif_decaissement();
                // this._u_close_mod_form();
                this.nom_motif_decaissement= "";
                this.isLoadSaveMainButtonModal = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },

    update_motif_decaissement_externe(e){
      e.preventDefault();
      this.isLoadSaveMainButtonModal = true;
      const newurl = this.url+"motif-decaissement-update/"+this.idElementSelected+"/update";
      var form = {
        "description":this.nom_motif_decaissement,
      }
      this.messageError = false;
      return axios
            .put(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_destination_motif_decaissement();
                  this.isLoadSaveMainButtonModal = false;
                  this.nom_motif_decaissement = "";
                  this.wantToUpdate = false;
                  this.indexTopUpdate = null;
                  return;
                }
                var err = response.data.message.errors;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            })
            .catch(error =>{
              console.log(error);
            })
    },
    desable_activated_status_motif_decaissement_externe(){ //from : 1 faveur ou 2 achat normal
      const newurl = this.url+"motif-decaissement-desable-activated/"+this.idElementSelected;

      this.messageError = false;
      this.isLoadSaveMainButtonSecond = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_destination_motif_decaissement();
                this.wantToUpdate = false;
                this.indexTopUpdate = null;
                this.nom_motif_decaissement = "";
                this.isLoadSaveMainButtonSecond = false;
                return;
            }
            var err = response.data.message.errors;
            this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
            this.isLoadSaveMainButtonSecond = false;
          }).catch(error =>{
            console.log(error);
          })
  },

    add_client_abonne(e){
    e.preventDefault();
    const newurl = this.url+"client-create-one";
    var form = this._u_fx_form_data_client();
    this.messageError = false;
    this.isLoadSaveMainButton = true;
    return axios
          .post(newurl,form,{headers: this.tokenConfig})
          .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this._u_fx_form_init_field();
                this.get_client_abonne();
                this.isLoadSaveMainButton = false;
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButton = false;
          })
          .catch(error =>{
            console.log(error);
          })
  },
    get_client_abonne(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"client-get-all/"+limit+"/"+offset;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              this.isShow = false;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },
    add_crediter_amount_client(e){
      e.preventDefault();
      const newurl = this.url+"client-crediter-account/"+this.idElementSelected+"/"+this.montant_a_crediter_client;
      this.messageError = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  this.get_client_abonne();
                  this.isLoadSaveMainButtonModal = false;
                  this._u_close_mod_form();
                  this.isShow = false;
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButtonModal = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },

    add_qte_a_retirer(){
      this.isLoadSaveMainButtonModal = true;
      console.log(this.ArticleValidateNego);
      const newurl = this.url+"save-article-retire-commande";
      var form = new FormData();
      // form.append('idcommande',cmd);
      form.append('iduser',this.users_id);
      form.append('pwd', this.password_op);
      if(Object.keys(this.ArticleValidateNego).length < 1){
        this._u_fx_config_error_message_bottom("Message",['Impossible de valider cette operation car aucun article n\'a été déclaré à rétirer'],'alert-danger');
        this.isLoadSaveMainButtonModal = false;
        return;
      }
      this.messageError = false;
      for(key in this.ArticleValidateNego){
          form.append('vente_detail_id[]', this.ArticleValidateNego[key][0]);
          form.append('qte[]', this.ArticleValidateNego[key][1]);
    	}
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                var err = response.data.message.success;
                this.isLoadSaveMainButtonModal = false;
                this._u_fx_config_error_message("Succès",[err],'alert-success');
                this.get_commande_magazinier(3);
                this.ArticleValidateNego = {}
                this.password_op = null;
                this._u_close_mod_form();
                return;
              }
              var err = response.data.message.errors;
              this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
              this.isLoadSaveMainButtonModal = false;

            }).catch(error =>{
              console.log(error);
            })
    },
    add_historique_retranche_pv(e){
      e.preventDefault();
      const newurl = this.url+"add-pv-historique";
      var form = new FormData();
      form.append('depots_id',this.depots_id);
      form.append('magaz_source_id',this.usersDestTransfert);
      form.append('users_id',this.users_id);
      form.append('date_historique', this.date_approvisionnement);
      // form.append('status_operation',0);

        for(var i=0; i< this.tabListData.length; i++){
          form.append('articles_id[]', this.tabListData[i]['id']);
          form.append('qte_perdue[]', this.tabListData[i]['qte']);
  			}
        if(this.tabListData.length < 1){
          this._u_fx_config_error_message("Erreur",["Veuillez renseigner les articles"],'alert-danger');
          return;
        }
      this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .post(newurl,form,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this._u_fx_form_init_field();
                  // this.get_article();
                  this.isLoadSaveMainButton = false;
                  this.tabListData=[];
                  this.usersListParDepot = [];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    get_historique_pv_magazinier(limit=this.PerPaged,offset=0, indexPage=0){

      const newurl = this.url+"pv-historique/"+this.dateFilter+"/"+limit+"/"+offset+"/"+this.idUserToGetHistoPv;
      console.log(this.idUserToGetHistoPv);
      this.isNoReturnedData = false;
      this.dataToDisplay=[];
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              // console.log("===Log===");
              // console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
              this.currentIndexPage = indexPage;
              this.paginationTab=[];
              this._u_fx_generate_pagination(response.data.all);
            }).catch(error =>{
              console.log(error);
            })
    },


    //QUELQUES FONCTIONS COTE ADMINISTRATION


    //FONCTION POUR RECHERCHER
    _searchDataFacturier(limit=this.PerPaged,offset=0, indexPage=0){
      if(this.dataToSearch =="" || this.RadioCheckedValue==""){
        this.isResearchPagination = false;
        this.get_commande_facturier(this.stateStatus);
        return;
      }
      // var isParameterAdvanced = 0; //On a pas coch
      if(this.checkBoxArticles.length ==2){
        this.isParameterAdvanced = 3;// POUR TOUS LES PARAMETRES
      }
      if(this.checkBoxArticles.length ==1){
        this.isParameterAdvanced = this.checkBoxArticles[0];
      }
      if(this.checkBoxArticles.length ==0){
        this.isParameterAdvanced = 0;// POUR TOUS LES PARAMETRES
      }
      if(this.dateFilter !==null){
        this._u_formatOnlyDate(this.dateFilter);
      }
      const newurl = this.url+"commandes-get-all-search/"+this.users_id+"/"+this.stateStatus+"/"+this.dateFilter+"/"+this.dataToSearch+"/"+this.RadioCheckedValue+"/"+this.isParameterAdvanced+"/"+this.PerPaged+"/"+offset+"/facturier";
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.currentIndexPage = indexPage;
              var total = this._u_fx_calculateTotal_Record_Recherche();
              this.paginationTab=[];
              this._u_fx_generate_pagination(total);
              this.isResearchPagination = true;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    _searchDataCaissier(limit=this.PerPaged,offset=0, indexPage=0){
      if(this.dataToSearch =="" || this.RadioCheckedValue==""){
        this.isResearchPagination = false;
        this.get_commande_caissier(this.stateStatus);
        return;
      }
      // var isParameterAdvanced = 0; //On a pas coch
      if(this.checkBoxArticles.length ==2){
        this.isParameterAdvanced = 3;// POUR TOUS LES PARAMETRES
      }
      if(this.checkBoxArticles.length ==1){
        this.isParameterAdvanced = this.checkBoxArticles[0];
      }
      if(this.checkBoxArticles.length ==0){
        this.isParameterAdvanced = 0;// POUR TOUS LES PARAMETRES
      }
      if(this.dateFilter !==null){
        this._u_formatOnlyDate(this.dateFilter);
      }
      const newurl = this.url+"commandes-get-all-search/"+this.users_id+"/"+this.stateStatus+"/"+this.dateFilter+"/"+this.dataToSearch+"/"+this.RadioCheckedValue+"/"+this.isParameterAdvanced+"/"+this.PerPaged+"/"+offset+"/caissier";
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.currentIndexPage = indexPage;
              var total = this._u_fx_calculateTotal_Record_Recherche();
              this.paginationTab=[];
              this._u_fx_generate_pagination(total);
              this.isResearchPagination = true;

              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    _searchDataByMagazinier(limit=this.PerPaged,offset=0, indexPage=0){
      if(this.dataToSearch =="" || this.RadioCheckedValue==""){
        this.isResearchPagination = false;
        this.get_commande_magazinier(this.stateStatus);
        return;
      }
      // var isParameterAdvanced = 0; //On a pas coch
      if(this.checkBoxArticles.length ==2){
        this.isParameterAdvanced = 3;// POUR TOUS LES PARAMETRES
      }
      if(this.checkBoxArticles.length ==1){
        this.isParameterAdvanced = this.checkBoxArticles[0];
      }
      if(this.checkBoxArticles.length ==0){
        this.isParameterAdvanced = 0;// POUR TOUS LES PARAMETRES
      }
      if(this.dateFilter !==null){
        this._u_formatOnlyDate(this.dateFilter);
      }
      const newurl = this.url+"commandes-get-by-depot-search/"+this.dpot_id+"/"+this.stateStatus+"/"+this.dateFilter+"/"+this.dataToSearch+"/"+this.RadioCheckedValue+"/"+this.isParameterAdvanced+"/"+this.PerPaged+"/"+offset+"/depot";
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.currentIndexPage = indexPage;
              var total = this._u_fx_calculateTotal_Record_Recherche();
              this.paginationTab=[];
              this._u_fx_generate_pagination(total);
              this.isResearchPagination = true;

              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    _searchDataAdmin(limit=this.PerPaged,offset=0, indexPage=0){

      if(this.dataToSearch =="" || this.RadioCheckedValue==""){
        this.isResearchPagination = false;
        this.get_commande_admin(this.stateStatus);
        return;
      }
      // var isParameterAdvanced = 0; //On a pas coch
      if(this.checkBoxArticles.length ==2){
        this.isParameterAdvanced = 3;// POUR TOUS LES PARAMETRES
      }
      if(this.checkBoxArticles.length ==1){
        this.isParameterAdvanced = this.checkBoxArticles[0];
      }
      if(this.checkBoxArticles.length ==0){
        this.isParameterAdvanced = 0;// POUR TOUS LES PARAMETRES
      }
      if(this.dateFilter !==null){
        this._u_formatOnlyDate(this.dateFilter);
      }
      const newurl = this.url+"commandes-all-by-status-search/"+this.stateStatus+"/"+this.dateFilter+"/"+this.dataToSearch+"/"+this.RadioCheckedValue+"/"+this.isParameterAdvanced+"/"+this.PerPaged+"/"+offset+"/status";
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.montantTotalAllCommandeParTypeVente = response.data.sommesTotalAllCommandes;
              this.currentIndexPage = indexPage;
              var total = this._u_fx_calculateTotal_Record_Recherche();
              this.paginationTab=[];
              this._u_fx_generate_pagination(total);
              this.isResearchPagination = true;

              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },

    _searchDataByMagazinierFaveur(limit=this.PerPaged,offset=0, indexPage=0){
      if(this.dataToSearch =="" || this.RadioCheckedValue==""){
        this.isResearchPagination = false;
        this.get_commande_faveur_magazinier(this.stateStatus);
        return;
      }
      // var isParameterAdvanced = 0; //On a pas coch
      if(this.checkBoxArticles.length ==2){
        this.isParameterAdvanced = 3;// POUR TOUS LES PARAMETRES
      }
      if(this.checkBoxArticles.length ==1){
        this.isParameterAdvanced = this.checkBoxArticles[0];
      }
      if(this.checkBoxArticles.length ==0){
        this.isParameterAdvanced = 0;// POUR TOUS LES PARAMETRES
      }
      if(this.dateFilter !==null){
        this._u_formatOnlyDate(this.dateFilter);
      }
      const newurl = this.url+"commandes-faveur-get-by-depot-search/"+this.dpot_id+"/"+this.stateStatus+"/"+this.dateFilter+"/"+this.dataToSearch+"/"+this.RadioCheckedValue+"/"+this.isParameterAdvanced+"/"+this.PerPaged+"/"+offset+"/depot";
      if(this.isShow){
        this.isShow = !this.isShow;
      }
      this._u_set_table_title_with_date();
      this.dataToDisplay =[];
      this.isNoReturnedData = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              this.ListFiltreData = response.data.nombreVenteType;
              this.currentIndexPage = indexPage;
              var total = this._u_fx_calculateTotal_Record_Recherche();
              this.paginationTab=[];
              this._u_fx_generate_pagination(total);
              this.isResearchPagination = true;

              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }

            }).catch(error =>{
              console.log(error);
            })
    },
    _refrechData(callbackFunction){
      // console.log(this.stateStatus);
      callbackFunction(this.stateStatus);
    },
    _u_fx_calculateTotal_Record_Recherche(){
      var total = 0;
      if(this.isParameterAdvanced==3 || this.isParameterAdvanced==2){
        if(this.stateStatus==1){
          total = parseInt(this.ListFiltreData.attente);
        }else{
          if(this.stateStatus==2){
            total = parseInt(this.ListFiltreData.payer);
          }else{
            if(this.stateStatus==3){
              total = parseInt(this.ListFiltreData.livrer);
            }else{
              total = parseInt(this.ListFiltreData.annuler);
            }
          }
        }
      }else{
        total = parseInt(this.ListFiltreData.attente)+parseInt(this.ListFiltreData.payer)+parseInt(this.ListFiltreData.livrer)+parseInt(this.ListFiltreData.annuler);
      }
      return total;
    },
    //FONCTION POUR RECHERCHER FIN
    _u_create_line_article(){
    const isFaveur = this.checkIsFaveur.length > 0 ? 1 : 0;
    // const depots = isFaveur == 1 ? this.depot_central_id : this.depots_id;
    const depots = this.depots_id;
    const newurl = this.url+"articles-search-data-commande/"+this.codeArticle+"/"+this.qte+"/"+depots+"/"+isFaveur+"/search";
      if(this.depots_id ==""){
        this._u_fx_config_error_message_bottom("Message",['Veuillez selectionner un dépôt traiteur'],'alert-danger');
        return;
      }
      // if(!Number(this.qte)){
      //   this._u_fx_config_error_message_bottom("Message",['La quantité est invalide'],'alert-danger');
      //   return;
      // }
      this.messageErrorBottom = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                response.data.data.isfaveur = isFaveur;
                this.tabListData.push(response.data.data);
                var mntAchatUni = parseFloat(response.data.data.prix_unit)*parseFloat(response.data.data.qte);
                this.montantTotalAchat += mntAchatUni;
                this._u_fx_config_error_message_bottom("Message",[response.data.message.success],'alert-success');
                this.codeArticle = "";
                this.qte = 0;
                this.isLoadSaveMainButtonModal = false;
                if(isFaveur == 1){
                  this.ListIdArticleFaveur.push(Number(response.data.data.id));
                }
                this.checkIsFaveur = new Array();
                return;
              }
              this._u_fx_config_error_message_bottom("Message",[response.data.message.errors],'alert-danger')
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })


    },
    _u_remove_line_list_art(index){
      var montantAretrancher = parseFloat(this.tabListData[index].prix_unit) * parseInt(this.tabListData[index].qte);
      this.montantTotalAchat -= montantAretrancher;

      if(this.tabListData[index].isfaveur == 1){
        const idArticle = Number(this.tabListData[index].id);
        let i = this.ListIdArticleFaveur.indexOf(idArticle);
        this.ListIdArticleFaveur.splice(i,1);
      }
      this.tabListData.splice(index,1);
      this._u_fx_config_error_message_bottom("Message",['Bien supprimer'],'alert-info');


    },
    _u_create_line_article_appro(){
      const newurl = this.url+"articles-search-by-code/"+this.codeArticle+"/code";
      if(this.qte < 1 || this.qteTotal < 1 || this.qtePv < 0){
        this._u_fx_config_error_message_bottom("Message",['La quantité doit être superieure à 1'],'alert-danger');
        return;
      }
      if(Number(this.qte) + Number(this.qtePv) != Number(this.qteTotal)){
        this._u_fx_config_error_message_bottom("Message",['La somme de quantités bonne et PV doit être egale à la quantité totale'],'alert-danger');
        return;
      }
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.data.length <1){
                this._u_fx_config_error_message_bottom("Message",['Le code article n\'existe pas'],'alert-danger');
                this.isLoadSaveMainButtonModal = false;
                return;
              };
              this.tabListData.push({info:response.data.data,qteTotal:this.qteTotal,qtePv:this.qtePv,qtea:this.qte})
              console.log(this.tabListData);
              this.messageErrorBottom = false;
              this._u_fx_field_multi_form_art();
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_create_line_article_appro_inter_depot(){
      const newurl = this.url+"articles-search-data-appro-inte-depot/"+this.codeArticle+"/"+this.qte+"/"+this.dpot_id+"/"+this.users_id+"/search";

      if(this.codeArticle ==""){
        this._u_fx_config_error_message_bottom("Message",['Le champs article ne doit pas être vide'],'alert-danger');
        return;
      }
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                this.tabListData.push(response.data.data);
                this._u_fx_config_error_message_bottom("Message",[response.data.message.success],'alert-success');
                this.codeArticle = "";
                this.qte = 0;
                this.isLoadSaveMainButtonModal = false;
                console.log(this.tabListData);
                return;
              }
              this._u_fx_config_error_message_bottom("Message",[response.data.message.errors],'alert-danger')
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_create_line_article_pv_perdue_depot(){
      if(this.codeArticle ==""){
        this._u_fx_config_error_message_bottom("Message",['Le champs article ne doit pas être vide'],'alert-danger');
        return;
      }
      if(this.depots_id =="" || this.usersDestTransfert =="" || this.usersDestTransfert == null){
        this._u_fx_config_error_message_bottom("Message",['Le champs dépôt et magasinier source ne doivent pas être vide'],'alert-danger');
        return;
      }
      const newurl = this.url+"articles-search-data-pv-perdue-depot/"+this.codeArticle+"/"+this.qte+"/"+this.depots_id+"/"+this.usersDestTransfert+"/search";
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                this.tabListData.push(response.data.data);
                this._u_fx_config_error_message_bottom("Message",[response.data.message.success],'alert-success');
                this.codeArticle = "";
                this.qte = 0;
                this.isLoadSaveMainButtonModal = false;
                console.log(this.tabListData);
                return;
              }
              this._u_fx_config_error_message_bottom("Message",[response.data.message.errors],'alert-danger')
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_create_line_article_transfert(){
      const newurl = this.url+"articles-search-data-transfert/"+this.codeArticle+"/"+this.qte+"/"+this.users_id+"/search";

      if(this.codeArticle ==""){
        this._u_fx_config_error_message_bottom("Message",['Le champs article ne doit pas être vide'],'alert-danger');
        return;
      }
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                this.tabListData.push(response.data.data);
                this._u_fx_config_error_message_bottom("Message",[response.data.message.success],'alert-success');
                this.codeArticle = "";
                this.qte = 0;
                this.isLoadSaveMainButtonModal = false;
                console.log(this.tabListData);
                return;
              }
              this._u_fx_config_error_message_bottom("Message",[response.data.message.errors],'alert-danger')
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_open_mod_form(art, from=null){
      this._u_fx_form_init_field();
      this.isAction = true;
      if(from ==2){
        this.isAction = false;
        this.modalTitle = "MODIFIER LE PRIX DE L'ARTICLE DANS L'INTERVAL DE "+art.qte_decideur_min+ " - "+art.qte_decideur_max;
        this.prix_unitaire = art.prix_unitaire;
        this.price_id = art.id;
        this.styleModal = 'block';
        console.log(art);
        return;
      }
      if(from ==1){
        this.articles_id = art.id;
        this.modalTitle = "FIXER LE PRIX DE L'ARTICLE "+art.nom_article;
        this.styleModal = 'block';

        //Take last configuration for price
        this.qte_decideur_min = 0;
        if(art.logic_detail_data.length >0){
          const ind = parseInt(art.logic_detail_data.length -1);
          this.qte_decideur_min = +art.logic_detail_data[ind].qte_decideur_max;
        }
      }
      if(from ==3){
        this.isWantBeDeleted = true;
        this.price_id = art.id;
        this.modalTitle = "SUPPRESSION DEFINITIVE DU PRIX DE L'ARTICLE";
        this.styleModal = 'block';
      }


      // console.log(art.logic_detail_data);
    },
    _u_open_mod_form_config_faveur(art, from=null){


      // this._u_fx_form_init_field();
      this.isActionFaveur = true;
      this.ListPricesArticle = art.logic_detail_data;

      if(from ==1){
        this.articles_id = art.id;
        this.modalTitle = "CONFIGURATION FAVEUR DE L'ARTICLE "+art.nom_article;
      }
      if(from ==2){
        this.isActionFaveur = false;
        this.modalTitle = "MODIFIER CONFIGURATION FAVEUR DE L'ARTICLE "+art.nom_article;
        this.qte_faveur = art.logic_config_article_faveur[0].qte_faveur;
        this.prix_id = art.logic_config_article_faveur[0].prix_id[0].id;
        this.config_faveur_id = art.logic_config_article_faveur[0].id;
        this.styleModalFaveur = 'block';
        console.log(art);
        return;
      }


      this.styleModalFaveur = 'block';
      console.log(this.ListPricesArticle);
    },
    _u_open_mod_credite_account_client(client, from=null){
      this.modalTitle = "CREDITER LE COMPTE DU CLIENT "+client.nom_client+" "+client.prenom_client;
      this.montant_actuel_client = client.montant;
      this.idElementSelected = client.id;
      this.montant_a_crediter_client = 0;
      this.styleModal = 'block';
    },
    _u_open_mod_add_kg_pv(art, from=null){

      this.articles_id = art.id;
      this.modalTitle = "AJOUTER Kg PV L'ARTICLE "+art.nom_article;
      this.qte_pv_kg = 0;
      this.qte_restaurer = art.qte_stock_pv;
      this.styleModalFaveur = 'block';
      console.log(this.ListPricesArticle);
    },
    _u_close_mod_form(){
      this.styleModal = 'none';
      this.styleModalFaveur = 'none';
      this.styleModalDetail = 'none';
    },
    _u_open_mod_popup_caisse(cmd,val){
      if(val==3){
        this.isNoQuantity = true;
      }else{
        this.isNoQuantity = false;
      }
      console.log(val);
      this.modalTitle = "VALIDATION DU PAYEMENT DE LA FACTURE "+cmd.numero_commande+" DU CLIENT "+cmd.nom_client;
      this.commande_id = cmd.id;
      this.somme_commande = cmd.logic_somme;
      this.styleModal = 'block';
    },
    _u_open_mod_popup_facturier_annulation(){
      this.modalTitle = "ANNULER "+this.checkBoxAchatSelected.length+" ACHAT(S)";
      this.styleModal = 'block';
    },
    _u_open_mod_popup_appro_annulation(){
      this.modalTitle = "ANNULER "+this.checkBoxAchatSelected.length+" APPROVISIONNEMENT(S)";
      this.styleModalFaveur = 'block';
    },
    _u_open_mod_popup_transfert(){
      this.modalTitle = "ANNULER "+this.checkBoxAchatSelected.length+" TRANSFERT(S)";
      this.styleModalFaveur = 'block';
    },
    _u_open_mod_popup_caissier_principal_validation_decaissement(dec){
      console.log("===DECAI===");
      console.log(dec);
      this.modalTitle = "VALIDATION DE LA RECEPTION DU MONTANT "+dec.montant+" USD DE LE(LA) CAISSIER(E) "+dec.users_id_from.nom+" "+dec.users_id_from.prenom;
      this.decaissement_id = dec.id;
      this.styleModal = 'block';
    },
    _u_open_mod_popup_magaz(cmd,val,fromLivrePartiel=null){
      // console.log(cmd);

      this.isPartielle = false;
      if(val==3){
        this.isNoQuantity = true;
      }else{
        this.isNoQuantity = false;
      }
      this.hasAlreadyDelivered = false;
      this.modalTitle = "VALIDATION DE LA LIVRAISON DE LA FACTURE "+cmd.numero_commande+" DU CLIENT "+cmd.nom_client;
      this.commande_id = cmd.id;
      this.somme_commande = cmd.logic_somme;
      this.styleModal = 'block';
      if(cmd.depots_id_first_livrer == this.dpot_id){
        this.hasAlreadyDelivered = !this.hasAlreadyDelivered;
      }
      if(fromLivrePartiel){
        this.modalTitle = "VALIDATION PARTIELLE DE LA LIVRAISON DE LA FACTURE "+cmd.numero_commande+" DU CLIENT "+cmd.nom_client;
        this.isPartielle = true;
      }
      // console.log(cmd);
    },
    _u_open_mod_popup_magaz_validate_appro_inter_depot(cmd,val){
      this.modalTitle = "VALIDATION DE L'APPROVISIONNEMENT VENANT DU "+cmd.depots_id_source[0].nom+" EN DATE DU "+cmd.date_approvisionnement;
      this.commande_id = cmd.id;
      this.styleModal = 'block';
      console.log(cmd);
    },
    _u_open_mod_popup_magaz_transfert(cmd,val){
      this.modalTitle = "VALIDATION DU TRANSFERT VENANT DE "+cmd.users_id_source[0].nom+" "+cmd.users_id_source[0].prenom+" EN DATE DU "+cmd.date_transfert;
      this.commande_id = cmd.id;
      this.styleModal = 'block';
      console.log(cmd);
    },
    _u_open_mod_popup_magaz_restaure_pv(cmd,val){
      // console.log(cmd);
      this.modalTitle = "APPROVISIONNEMENT PV RESTAURATION DE L'ARTICLE "+cmd.code_article+" : "+cmd.nom_article;
      this.articles_id = cmd.id;
      // this.qte_restaurer = cmd.qte_stock_pv;
      this.qte_restaurer = Number(cmd.pv_en_kg)/Number(cmd.poids);
      this.poids_article = cmd.poids;
      this.qte_restaurer_init = cmd.qte_stock_pv;
      this.qte_pv_kg = cmd.pv_en_kg;
      this.qte_perdue = Number(this.qte_restaurer_init) - Number(this.qte_restaurer);
      this.depots_id ="";
      this.usersDestTransfert = "";
      this.usersListParDepot = [];
      this.styleModal = 'block';
      // console.log(cmd);
      // console.log(this.qte_pv_kg);
    },
    _u_open_mod_popup_edit_qte_stock(cmd, art){
      // console.log(cmd);
      this.modalTitle = "AJUSTEMENT STOCK DE L'ARTICLE "+art.articles_id[0].code_article+" : "+art.articles_id[0].nom_article+" DU DEPOT "+cmd.nom;
      this.qte_reelle = art.qte_stock;
      this.qte_virtuelle = art.qte_stock_virtuel;
      this.depots_id = cmd.id;
      this.articles_id = art.articles_id[0].id;

      this.styleModal = 'block';
      console.log(cmd);
      console.log(art);
      // console.log(this.qte_pv_kg);
    },
    _u_open_mod_popup_edit_qte_stock_personnel(cmd, art){
      // console.log(cmd);
      this.modalTitle = "AJUSTEMENT STOCK PERSONNEL DE L'ARTICLE "+art.code_article+" : "+art.nom_article+" DU MAGASINIER "+cmd.nom;
      this.qte_reelle = art.qte_stock;
      this.idStockPerso = art.idStockPerso;
      // this.qte_virtuelle = art.qte_stock_virtuel;
      // this.depots_id = cmd.id;
      // this.articles_id = art.articles_id[0].id;

      this.styleModal = 'block';
      // console.log(cmd);
      console.log(this.idStockPerso);
      // console.log(this.qte_pv_kg);
    },
    _u_open_mod_popup_photo(userid){
      //console.log("=====ARTICLE=====");
      //console.log(cmd);
      this.modalTitle = "MODIFICATION DE LA PHOTO DU PROFILE";
      this.styleModal = 'block';
    },
    _u_open_mod_popup_systeme(i){
      this.password_op = null;
      this.passIsCorrectCanProcceed = false;
      if(i == 1){
        this.modalTitle = "CLOTURE STOCK DEPOT JOURNALIERE";
        this.textDescriptif = "Attentions, vous êtes sur le point de faire la clôture journalière du stock de tous les dépôts, assurez vous que c'est le bon moment de le faire car cette action est irréversible. Cette action est sensée être faite à la fin de la journée vers 18h30";
        this.typeAction = 1;
      }else if (i == 2) {
        this.modalTitle = "CLOTURE CAISSE JOURNALIERE";
        this.textDescriptif = "Attentions, vous êtes sur le point de faire la clôture journalière de la caisse générale, assurez vous que c'est le bon moment de le faire car cette action est irréversible. Cette action est sensée être faite à la fin de la journée vers 18h30";
        this.typeAction = 2;
      }else if (i == 3) {
        this.modalTitle = "ACTIVER TOUS LES COMPTES";
        this.textDescriptif = "Attentions, vous êtes sur le point de faire d'activer tous les comptes du système sauf ceux des managers et des administrateurs du système, assurez vous que c'est le bon moment de le faire.";
        this.typeAction = 3;
      }else if (i == 4) {
        this.modalTitle = "DESACTIVER TOUS LES COMPTES";
        this.textDescriptif = "Attentions, vous êtes sur le point de faire de desactiver tous les comptes du système sauf ceux des managers et des administrateurs du système, assurez vous que c'est le bon moment de le faire. Cette action est sensée être faite à la fin de la journée vers 18h30";
        this.typeAction = 4;
      }
      this.styleModal = 'block';

      // console.log(cmd);
    },
    _u_open_mod_popup_validation_a_retirer(){
      this.modalTitle = "VALIDER DE RETRAIT RENSEIGNES";
      this.styleModalFaveur = 'block';
    },
    _u_open_mod_popup_detail(det, factcode){
      this.modalTitle = "HISTORIQUE RETRAIT QUANTITE CLIENT - FACTURE "+factcode;
      this.styleModalDetail = 'block';
      this.detailOperationAretirer = det.logic_historique_a_retirer;
      this.QteTotalOperationDejaRetirer = det.logic_historique_a_retirer.reduce((accumulatedTotal, qteItem) =>parseFloat(accumulatedTotal)+parseFloat(qteItem.qte_retirer) ,0);
      console.log("==DETAIL==");
      console.log(det.logic_historique_a_retirer);
    },
    _u_get_today(){
      var currentDate = new Date();
      var currentDateWithFormat = new Date().toJSON().slice(0,10).replace(/-/g,'-');
      this.date_approvisionnement = currentDateWithFormat;
      this.date_vente = currentDateWithFormat;
      this.dateRapport = currentDateWithFormat;
      this.dateRapportFin = currentDateWithFormat;
      this.dateRapportGen = currentDateWithFormat;
      this.dateFilter = currentDateWithFormat;
      this.dateFilterEnd = currentDateWithFormat;
      this.date_transfert =currentDateWithFormat;
      this.dateRapportDebut = currentDateWithFormat;
      this.dateRapportEnd = currentDateWithFormat;
      this.dateRapportDebutAppro = currentDateWithFormat;
      this.dateRapportEndAppro = currentDateWithFormat;
    },
    _u_see_detail_tab(data, indLine=null){
      this.codeIdArticlePrint = data.id;
      this.detailTab = data;
      this.isShow = true;
      //pour profile Image admin update
      this.iduserToChangeProfile = data.id;

      if(indLine !=null){
        this.currentLineSelectedInList = indLine;
      }
      this.ArticleValidateNego = {};
      // console.log("==FromHere===");
      // console.log(this.detailTab);
    },
    _u_see_detail_tab_admin_users(data, indLine=null){
      this.codeIdArticlePrint = data.id;
      this.detailTab = data;
      this.isShow = !this.isShow;
      //pour profile Image admin update
      this.iduserToChangeProfile = data.id;
      if(indLine !=null){
        this.currentLineSelectedInList = indLine;
      }

      //POUR COCHE CHECK BOX IF USER HAVE ACCES TO PV
      // if(data.logic_droit_access.length > 0){
      //   if(data.logic_droit_access[0].g_pv==1){
      //     this.accessGestionPv = true;
      //   }else{
      //     this.accessGestionPv = false;
      //   }
      // }else{
      //   this.accessGestionPv = false;
      // }
    },
    _u_get_code_facture(){
      const newurl = this.url+"commandes-generate-code";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.numero_commande =response.data.data;
              this.depot_central_id = response.data.depot_central;
              // console.log(this.depotList);
            }).catch(error =>{
              console.log(error);
            })
    },
    _u_fx_create_tab_prod_validate_nego(idarticle, valueMontantInput){
      // console.log(valuInput);
        if(valueMontantInput !="" && valueMontantInput > 0){
          var arry = [idarticle,valueMontantInput];
          this.ArticleValidateNego[idarticle] = arry;

        }else{
          delete this.ArticleValidateNego[idarticle];
        }
        // console.log(this.ArticleValidateNego);

    },
    _u_fx_create_tab_a_retirer(idarticle, e, qte_vendue,detOperation){
      let totalQuantiteDejaRetirer = detOperation.logic_historique_a_retirer.reduce((accumulatedTotal, qteItem) =>parseFloat(accumulatedTotal)+parseFloat(qteItem.qte_retirer) ,0);
      console.log(e.target.value);
      console.log(qte_vendue);

      if(e.target.value != "" && parseFloat(e.target.value) > 0 && parseFloat(e.target.value) <= parseFloat(qte_vendue)){
        let tot = parseFloat(totalQuantiteDejaRetirer) + parseFloat(e.target.value);
          if(tot <= qte_vendue){
            var arry = [idarticle,e.target.value];
            this.ArticleValidateNego[idarticle] = arry;
          }else{
            e.target.value = 0;
            delete this.ArticleValidateNego[idarticle];
            this._u_fx_config_error_message_bottom("Message",['La Somme de quantités déjà rétirées ne doit pas depasser la quantité totale vendue!!'],'alert-danger');
          }

      }else{
        e.target.value = 0;
        delete this.ArticleValidateNego[idarticle];
        this._u_fx_config_error_message_bottom("Message",['Quantité renseignée invalide!!'],'alert-danger');
      }

      // e.target.value = 100;

      // console.log(this.ArticleValidateNego);
      // console.log(totalQuantiteDejaRetirer);
        // if(valueMontantInput !="" && valueMontantInput > 0){
        //   var arry = [idarticle,valueMontantInput];
        //   this.ArticleValidateNego[idarticle] = arry;
        //
        // }else{
        //   delete this.ArticleValidateNego[idarticle];
        // }
        console.log("===here=====");
        console.log(this.ArticleValidateNego);

    },
    _u_fx_get_montant(){
      // alert(this.users_id);
      if(this.users_id !=="undefined"){
        const newurl = this.url+"caisse-montant/"+this.users_id;
        return axios
              .get(newurl,{headers: this.tokenConfig})
              .then(response =>{
                this.montantCaisse = response.data.data;

              }).catch(error =>{
                console.log(error);
              })
      }else{
        console.log('Session expired!');
      }

    },
    _u_fx_bodyClicked(){
      // this.messageError =false;
      // this.messageErrorBottom =false;
    },
    _u_fx_generate_pagination(totalRecords){
      this.totalData = totalRecords;
      this.currentLineSelectedInList = -1;
      this.pageNumber = Math.ceil(parseInt(totalRecords) / parseInt(this.PerPaged));
      for (var i = 1; i <= this.pageNumber; i++) {
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        this.paginationTabIn ={
          "limit":parseInt(this.PerPaged),
          "offset":parseInt(offset)
        }
        this.paginationTab.push(this.paginationTabIn);

      }
      // console.log(this.paginationTab);
    },
    _u_next_page(callbackFunctionGetList){
      var i = (this.currentIndexPage+1)+1;
      if(i <= this.pageNumber){
        this.currentIndexPage +=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(this.PerPaged,offset,this.currentIndexPage);
      }
    },
    _u_previous_page(callbackFunctionGetList){
      var i = this.currentIndexPage;
      console.log(this.currentIndexPage);
      if(i < this.pageNumber && 0 < i){
        this.currentIndexPage -=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(this.PerPaged,offset,this.currentIndexPage);
      }
    },
    _u_next_page_decaissement_externe(callbackFunctionGetList){
      var i = (this.currentIndexPage+1)+1;
      if(i <= this.pageNumber){
        this.currentIndexPage +=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(null,this.PerPaged,offset,this.currentIndexPage);
      }
    },
    _u_previous_page_decaissement_externe(callbackFunctionGetList){
      var i = this.currentIndexPage;
      console.log(this.currentIndexPage);
      if(i < this.pageNumber && 0 < i){
        this.currentIndexPage -=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(null,this.PerPaged,offset,this.currentIndexPage);
      }
    },


    _u_next_page_for_list_achat(callbackFunctionGetList){
      var i = (this.currentIndexPage+1)+1;
      if(i <= this.pageNumber){
        this.currentIndexPage +=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(this.stateStatus,this.PerPaged,offset,this.currentIndexPage);
      }
    },
    _u_previous_page_for_list_achat(callbackFunctionGetList){
      var i = this.currentIndexPage;
      console.log(this.currentIndexPage);
      if(i < this.pageNumber && 0 < i){
        this.currentIndexPage -=1;
        var offset = i==1?'0':parseInt(this.PerPaged)*(i-1);
        callbackFunctionGetList(this.stateStatus,this.PerPaged,offset,this.currentIndexPage);
      }
    },
    _u_formatDateFilter(callbackFunction){
      var date = new Date(this.dateFilter);
      var date2 = new Date(this.dateFilterEnd);
      this.dateFilter = this._u_formatOnlyDateAndReturn(date);
      this.dateFilterEnd = this._u_formatOnlyDateAndReturn(date2);
      this._u_set_table_title_with_date();
      callbackFunction(this.stateStatus);
    },
    _u_formatDateFilterWithoutStatus(callbackFunction){
      var date = new Date(this.dateFilter);
      this.dateFilter = this._u_formatOnlyDateAndReturn(date);
      this._u_set_table_title_with_date();
      callbackFunction();
    },
    _u_formatOnlyDate(date){
      var date = new Date(this.dateFilter);
      this.dateFilter = this._u_formatOnlyDateAndReturn(date);
    },
    _u_formatOnlyDateAndReturn(date){
      var date = new Date(date);
      var month = Number(date.getMonth())+1 < 10 ? '0'+Number(date.getMonth()+1):date.getMonth()+1;
      var day = date.getDate() < 10 ? '0'+date.getDate():date.getDate();
      return date.getFullYear()+'-'+month+'-'+day;
    },
    _u_set_table_title_with_date(){
      if(this.dateFilter !==null){
        this.dateFilterDisplay = "DU "+this.dateFilter;
      }else{
        this.dateFilterDisplay = "D'AUJORD'HUI";
      }
      console.log(this.dateFilter);
    },
    _u_DisplayImageToUpload(e){
      const image = e.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
        this.avatarMain = e.target.result;
      }
      this.fileMain = image;
      this._u_open_mod_popup_photo();

    },
    _u_reset_checkBoxSelected(){
      this.checkBoxArticles = new Array();
      this.checkBoxAchatSelected = new Array();
    },
    _u_get_last_achat_facturier(){
      const newurl = this.url+"achat-last-one-facturier/"+this.users_id;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              // this.dataToDisplay = response.data.data;
              this.lastFactureEncodede = response.data.data;
              console.log(response.data.data);


            }).catch(error =>{
              console.log(error);
            })
    },
    _u_change_droit_access(droit){
      var userID = this.codeIdArticlePrint;
      let newurl = null;
      if(droit==1){
         newurl = this.url+"users-change-pv-gestion-access/"+userID;
      }else if(droit==2){
        newurl = this.url+"users-change-achat-partiels-gestion-access/"+userID;
      }else if(droit==3){
         newurl = this.url+"users-access-menu-system/"+userID;
      }else if(droit==4){
         newurl = this.url+"users-access-system-cloture-stock/"+userID;
      }else if(droit==5){
         newurl = this.url+"users-access-system-cloture-caisse/"+userID;
      }else if(droit==6){
         newurl = this.url+"users-access-system-operation-comptes/"+userID;
      }
      // alert(newurl);
      // this.isLoadSaveMainButton = true;
      this.messageError = false;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this._u_fx_config_error_message("Succès",[err],'alert-success');
                  this.get_users_admin();
                  // this.get_article();
                  // this.isLoadSaveMainButton = false;
                  // this.tabListData=[];
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                // this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },
    _u_update_article(art, index){
      this.idElementSelected = art.id;
      // this.wantToUpdate = false;
      if(!this.wantToUpdate){
        this.indexTopUpdate = index;
        this.code_article = art.code_article;
        this.nom_article = art.nom_article;
        this.description = art.description;
        this.poids = art.poids;
        this.nombre_piece = art.nombre_piece;
        this.qte_restaurer = art.qte_stock_pv;
        this.qte_pv_kg_up = art.pv_en_kg;
        this.wantToUpdate = true;
      }else{
        this.indexTopUpdate = null;
        this._u_fx_form_init_field();
        this.wantToUpdate = false;
      }
      // this.wantToUpdate = false;
      // console.log(this.indexTopUpdate);

    },
    _u_update_motif(art, index){
      this.idElementSelected = art.id;
      // this.wantToUpdate = false;
      if(!this.wantToUpdate){
        this.indexTopUpdate = index;
        this.nom_motif_decaissement = art.description;
        this.wantToUpdate = true;
        this.MotifDecaissementStatus = art.is_active;
      }else{
        this.indexTopUpdate = null;
        // this._u_fx_form_init_field();
        this.nom_motif_decaissement = "";
        this.wantToUpdate = false;
      }

      // console.log(art);
      // this.wantToUpdate = false;
      // console.log(this.indexTopUpdate);

    },
    _u_check_if_password_op_is_correct(){
      const newurl = this.url+"users-check-correct-password/"+this.users_id+"/"+this.password_op;
      if(this.password_op ==""){
        this._u_fx_config_error_message_bottom("Message",['Le mot de passe des opération est obligatoire'],'alert-danger');
        return;
      }
      this.messageError = false;
      this.isLoadSaveMainButton = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
                if(response.data.message.success !=null){
                  var err = response.data.message.success;
                  this.isLoadSaveMainButton = false;
                  this.passIsCorrectCanProcceed = true;
                  // this._u_fx_config_error_message("Succès",[err],'alert-success');
                  return;
                }
                var err = response.data.message.errors;
                this._u_fx_config_error_message("Erreur",Object.values(err),'alert-danger');
                this.isLoadSaveMainButton = false;
            })
            .catch(error =>{
              console.log(error);
            })
    },

    // _u_hidden_display_message_error(){}
    // FONCTIONS UTILITIES COMMUNES
    _u_fx_config_error_message(title, message, classError){
     this.errorPopupClass.splice(1,1);
     this.errorPopupClass.push(classError);
     this.messageAlertConfig.title = title;
     this.messageAlertConfig.message = [];
     this.messageAlertConfig.message.push(message);
     this.messageError = true;
     // console.log(this.messageError);
     setTimeout(function(){
       this.messageError = false;
       console.log(this.messageError);

     },5000);
   },
    _u_fx_config_error_message_bottom(title, message, classError){
    this.errorPopupClassBottom.splice(1,1);
    this.errorPopupClassBottom.push(classError);
    this.messageAlertConfigBottom.title = title;
    this.messageAlertConfigBottom.message = [];
    this.messageAlertConfigBottom.message.push(message);
    this.messageErrorBottom = true;
    // console.log(this.messageAlertConfigBottom.message[0][0]);
  },
    _u_fx_form_init_field(){
      this.code_article = "";
      this.nom_article = "";
      this.poids = "";
      this.description = "";
      vthis.nombre_piece = 1;

      // this.articles_id = "";
      // this.type_prix = "";
      this.qte_decideur_min = "";
      this.qte_decideur_max = "";
      this.prix_unitaire = "";

      //FORMULAIRE DEMANDE DECAISSEMENT
      this.caissier ="";
      this.montant_decaisse="";
      this.note ="";

      this.destination ="";
      this.montant ="";

      //FORMULAIRE ADD DEPOT
      this.nom ="";
      this.responsable_id ="";
      this.adresse ="";

      //VARIANLE ADD Users
      this.nom ="";
      this.prenom ="";
      this.RadioCheckedSexe ="";
      this.tel ="";
      this.roles_id ="";
      this.dob ="";
      this.depot_id ="";
      this.date_debut_service ="";
      this.RadioCheckedIsMain ="";
      this.username ="";
      this.password_main ="";
      this.password_main_conf ="";
      this.password_op ="";
      this.password_op_conf ="";
      this.ancien_password_op = "";
      this.ancien_password_main = "";


      //CHAMPS APPROVISONNEMENT
      this.plaque = "";
      this.nom_chauffeur = "";
      this.num_chauffeur = "";
      this.num_bordereau ="";

      //CHAMPS APPRO INTER-Depot
      this.depots_id = "";

      //CHAMPS CONFIG FAVEUR
      this.prix_id = "";
      this.qte_faveur = "";

      //champs encaissement EXTERNE
      this.motif = "";
      this.montant_encaissement = "";

      //champs add clients
      this.nom_client_ab = "";
      this.prenom_client_ab = "";
      this.tel_client_ab = "";
      this.adresse_client_ab = "";




    },
    _u_fx_form_data_art(){
     var formData = new FormData();
     formData.append('code_article',vthis.code_article);
     formData.append('nom_article',vthis.nom_article);
     formData.append('description',vthis.description);
     formData.append('poids',vthis.poids);
     formData.append('users_id',vthis.users_id);
     formData.append('nombre_piece',vthis.nombre_piece);
     formData.append('qte_stock_pv',0);
     formData.append('pv_en_kg',0);
     formData.append('is_eligible_add_kg',0);



     return formData;
   },
    _u_fx_form_data_art_price(){
      var formData = new FormData();
      formData.append('articles_id',vthis.articles_id);
      formData.append('type_prix',vthis.type_prix);
      formData.append('prix_unitaire',vthis.prix_unitaire);
      formData.append('qte_decideur_min',vthis.qte_decideur_min);
      formData.append('qte_decideur_max',vthis.qte_decideur_max);
      formData.append('users_id',vthis.users_id);
      formData.append('price_id', this.price_id);
      return formData;
    },
    _u_fx_form_data_art_config_faveur(){
      var formData = new FormData();
      formData.append('articles_id',vthis.articles_id);
      formData.append('prix_id',vthis.prix_id);
      formData.append('qte_faveur',vthis.qte_faveur);
      formData.append('users_id',vthis.users_id);
      formData.append('config_faveur_id',vthis.config_faveur_id);
      return formData;
    },
    _u_fx_form_data_client(){
     var formData = new FormData();
     formData.append('nom_client',this.nom_client_ab);
     formData.append('prenom_client',this.prenom_client_ab);
     formData.append('telephone_client',this.tel_client_ab);
     formData.append('addresse',this.adresse_client_ab);
     formData.append('montant',0);
     return formData;
   },
    _u_fx_field_multi_form_art(){
      this.codeArticle ="";
      this.qte = 0;
      this.qteTotal = 0;
      this.qtePv = 0;
    },
    _u_fx_form_data_decaissement(){
     var formData = new FormData();
     formData.append('users_id_from',vthis.users_id);
     formData.append('users_id_dest',vthis.caissier);
     formData.append('montant',vthis.montant_decaisse);
     formData.append('note',vthis.note);
     formData.append('status_operation',0);
     formData.append('date_decaissement',"");
     return formData;
   },
    _u_fx_form_data_decaissement_externe(){
    var formData = new FormData();
    formData.append('users_id_from',vthis.users_id);
    formData.append('destination',vthis.destination);
    formData.append('montant',vthis.montant);
    formData.append('note',vthis.note);
    formData.append('date_decaissement',"");
    return formData;
  },
    _u_fx_form_data_encaissement_externe(){
      var formData = new FormData();
      formData.append('users_id',vthis.users_id);
      formData.append('montant_encaissement',vthis.montant_encaissement);
      formData.append('motif',vthis.motif);
      formData.append('date_encaissement',"");
      return formData;
    },
    _u_fx_form_data_users(){
    var formData = new FormData();
    formData.append('nom',this.nom);
    formData.append('prenom',this.prenom);
    formData.append('sexe',this.RadioCheckedSexe);
    formData.append('tel',this.tel);
    formData.append('roles_id',this.roles_id);
    formData.append('dob',this._u_formatOnlyDateAndReturn(this.dob));
    formData.append('depot_id',this.depot_id);
    formData.append('date_debut_service',this._u_formatOnlyDateAndReturn(this.date_debut_service));
    formData.append('is_main',this.RadioCheckedIsMain);
    formData.append('username',this.username);
    formData.append('password_main',this.password_main);
    formData.append('password_op',this.password_op);
    formData.append('photo','');
    return formData;
  },
    _u_fx_form_data_depot(){
     var formData = new FormData();
     formData.append('nom',vthis.nom);
     formData.append('adresse',vthis.adresse);
     formData.append('responsable_id', this.responsable_id);
     formData.append('is_central', this.RadioCheckedIsMain);
     return formData;
   },
    _u_set_base_url(){
      if(window.location.host==='127.0.0.1' || window.location.host==='localhost'){
        this.url = 'http://'+window.location.host+'/GestionBoutique/api/v1/';
        this.indexRoute = 2;
      }else{
        this.url = 'http://'+window.location.host+'/api/v1/';
        this.indexRoute = 1;
      }
    },
    _u_fx_to_load_router(){
    let pth = window.location.pathname.split('/');
    //pth = pth.split(',');
    console.log(window.location.host);
    if(pth[this.indexRoute] ==='admin-add-article' || pth[this.indexRoute] ==='admin-list-article' || pth[this.indexRoute]=='magaz-pv' || pth[this.indexRoute]=='admin-stock-pv' || pth[this.indexRoute]=='gerant-stock-pv' || pth[this.indexRoute]=='magaz-stock-pv' || pth[this.indexRoute]=='facturier-stock-pv' || pth[this.indexRoute]=='caissier-stock-pv'){
      this.get_article();
    }
    if(pth[this.indexRoute] ==='admin-add-appro' || pth[this.indexRoute] ==='facturier-add-achat' || pth[this.indexRoute]==='caissier-add-achat' ||  pth[this.indexRoute]=='admin-add-users' || pth[this.indexRoute] === 'magaz-add-appro-to-depot' || pth[this.indexRoute] == 'magaz-pv' || pth[this.indexRoute]=='admin-stock-pv' || pth[this.indexRoute]=='gerant-stock-pv' || pth[this.indexRoute]=='magaz-stock-pv' || pth[this.indexRoute]=='facturier-stock-pv' || pth[this.indexRoute]=='caissier-stock-pv' || pth[this.indexRoute] =='admin-add-vente' || pth[this.indexRoute]=='magaz-add-pv-historique' || pth[this.indexRoute]=='admin-add-pv-historique' || pth[this.indexRoute] == 'facturier-add-pv-historique' || pth[this.indexRoute] =='caissier-add-pv-historique'){
      this.get_depots();
    }
    if(pth[this.indexRoute]=='facturier-add-achat' || pth[this.indexRoute]==='caissier-add-achat' || pth[this.indexRoute]==='admin-add-vente'){

      this.get_stock_depots();

      if(pth[this.indexRoute]=='facturier-add-achat' || pth[this.indexRoute]=='caissier-add-achat'){
        this._u_get_last_achat_facturier();
        this.get_caissiers();
      }
      if(pth[this.indexRoute]=='admin-add-vente'){
        this.get_caissiers_main_and_admin();
      }

    }
    if(pth[this.indexRoute]=='facturier-list-achat'){
      this.get_commande_facturier();
    }
    if(pth[this.indexRoute]=='caissier-list-achat'){
      this.get_commande_caissier();
    }
    if(pth[this.indexRoute]=='magaz-list-achat'){
      this.get_commande_magazinier();
    }
    if(pth[this.indexRoute]=='magaz-list-achat-partiel'){
      this.isPartielFecthData = 1;
      this.get_commande_magazinier(3);
    }
    if(pth[this.indexRoute]=='magaz-list-achat-faveur'){
      this.get_commande_faveur_magazinier();
    }
    if(pth[this.indexRoute]=='admin-list-achat' || pth[this.indexRoute]=='gerant-list-achat'){
      this.get_commande_admin();
    }
    if(pth[this.indexRoute]=='admin-list-achat-partiel'){
      this.isPartielFecthData = 1;
      this.get_commande_admin(3);
    }
    if(pth[this.indexRoute]=='admin-list-negotiation-achat'){
      this.get_commande_attente_negotiation();
      // this.get_caissier_main();
      this.get_caissiers();
    }
    if(pth[this.indexRoute]=='caissier-add-decaissement'){
      this.get_caissier_main();
      this.get_decaisssement_caissier_secondaire();
    }
    if(pth[this.indexRoute]=='caissier-list-decaissement'){
      this.destination = 0;
      this.get_decaisssement_caissier_principale();
      this.get_destination_motif_decaissement();
    }
    if(pth[this.indexRoute]=='admin-histo-appro' || pth[this.indexRoute]=='gerant-histo-appro'){
      this.get_historique_approvisionnement();
    }
    if(pth[this.indexRoute]=='admin-stock' || pth[this.indexRoute]=='gerant-stock'){
      this.get_stock_depots();
    }
    if(pth[this.indexRoute]=='admin-config-depot'){
      this.get_depots();
      this.get_users_admin(100000000000);
      // get_users_admin(limit=this.PerPaged,offset=0, indexPage=0)
    }
    if(pth[this.indexRoute]=='admin-config-etat-critique'){
      this.get_configuration_etat_critique();
      this.get_destination_motif_decaissement();
    }
    if(pth[this.indexRoute]=='magaz-histo-appro'){
      this.get_historique_approvisionnement_by_depot();
    }
    if(pth[this.indexRoute]=='magaz-stock'){
      this.get_stock_depots_by_depot();
    }
    if(pth[this.indexRoute]=='admin-caisse' || pth[this.indexRoute]=='caissier-list-caissier'){
      this.get_caissiers();
    }
    if(pth[this.indexRoute]=='admin-encaissement-interne'){
      this.get_decaisssement_histo_interne_admin();
    }
    if(pth[this.indexRoute]=='admin-add-users'){
      this.get_profiles();
    }
    if(pth[this.indexRoute]=='admin-list-users'){
      this.get_users_admin();
    }
    if(pth[this.indexRoute] == 'magaz-histo-appro-inter-depot'){
      this.get_historique_approvisionnement_inter_depot_by_depot();
    }
    if(pth[this.indexRoute] == 'admin-histo-appro-inter-depot' || pth[this.indexRoute] == 'gerant-histo-appro-inter-depot'){
      this.get_historique_approvisionnement_inter_depot_admin();
    }
    if(pth[this.indexRoute] == 'caissier-encaissement-externe'){
      this.stateStatus = 1;
      this.get_encaisssement_externe(this.stateStatus);
    }
    if(pth[this.indexRoute] == 'admin-encaissement-externe'){
      this.stateStatus = null;
      this.get_encaisssement_externe(this.stateStatus);
    }
    if(pth[this.indexRoute] == 'admin-decaissement-externe'){
      this.destination = 0;
      this.get_decaisssement_externe_admin();
      this.get_destination_motif_decaissement();
    }
    if(pth[this.indexRoute] == 'admin-rapport'){
      this.get_depots();
    }
    if(pth[this.indexRoute]=='admin-config-system' || pth[this.indexRoute]=='facturier-config-system' || pth[this.indexRoute] == 'caissier-config-system' || pth[this.indexRoute]=='magaz-config-system' || pth[this.indexRoute]=='gerant-config-system'){
      this.get_etat_parametre_systeme();
    }
    if(pth[this.indexRoute] == 'magaz-add-transfert-to-magaz'){
      this.get_magasinier_by_depot();
    }

    if(pth[this.indexRoute] == 'magaz-histo-transfert-to-magaz'){
      this.get_historique_transfert_magaz_by_magaz();
    }
    if(pth[this.indexRoute] == 'admin-histo-transfert'){
      this.get_historique_transfert_admin();
    }

    if(pth[this.indexRoute] == 'magaz-stock-perso'){
      this.get_stock_personnel_par_magaz();
    }
    if(pth[this.indexRoute] == 'admin-stock-personnel'){
      this.get_stock_personnel_admin();
    }
    if(pth[this.indexRoute]=='magaz-pv' || pth[this.indexRoute]=='admin-stock-pv' || pth[this.indexRoute]=='gerant-stock-pv' || pth[this.indexRoute]=='magaz-stock-pv' || pth[this.indexRoute]=='facturier-stock-pv' || pth[this.indexRoute]=='caissier-stock-pv'){
      this.isLinkToLoadUserDepot = true;
    }
    if(pth[this.indexRoute] ==='admin-add-client' || pth[this.indexRoute] ==='admin-list-client'){
      this.get_client_abonne();
    }
    if(pth[this.indexRoute]=='magaz-list-achat-a-retirer'){
      // this.isGettingAretire = 1;
      this.get_commande_magazinier(3);
    }
    if(pth[this.indexRoute] == 'magaz-historique-pv' || pth[this.indexRoute] =='admin-historique-pv' || pth[this.indexRoute] =='facturier-historique-pv' || pth[this.indexRoute] =='caissier-historique-pv'){
      this.idUserToGetHistoPv = this.users_id;
      if(pth[this.indexRoute] =='admin-historique-pv'){
          this.idUserToGetHistoPv = 0;
      }
      this.get_historique_pv_magazinier();
    }


  }

  },
  watch : {
    messageError : function(val){
      // console.log("change to "+this.messageError);
    },
    dateFilter : function(val){
      // console.log('date filter changed');
      this.disabledDate.ranges[0].to = new Date(this.dateFilter);
      // console.log(this.disabledDate);
    },
    dateRapport : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapport = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportFin : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportFin = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportGen : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportGen = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportDebut : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportDebut = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportEnd : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportEnd = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportDebutAppro : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportDebutAppro = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },
    dateRapportEndAppro : function(val){
      var date = new Date(val);
      var month = date.getMonth()+1;
      month = month.toString().length ==1 ? '0'+month: month;
      var day = date.getDate();
      day =  day.toString().length ==1 ? '0'+day: day;
      this.dateRapportEndAppro = date.getFullYear()+'-'+month+'-'+day;
      //console.log(this.dateRapport);
    },

    qte_pv_kg : function(val){
      this.qte_restaurer = Number(this.qte_pv_kg) / Number(this.poids_article);
      this.qte_perdue = Number(this.qte_restaurer_init) - Number(this.qte_restaurer);
      this.qte_perdue = this.qte_perdue.toFixed(2);
    },
    depots_id : function(val){
      if(this.isLinkToLoadUserDepot){
        if(val){
          this.get_magasinier_by_depot(val);
        }
      }

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
