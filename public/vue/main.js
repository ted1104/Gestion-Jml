var vthis = new Vue({
  el : "#app",
  components: {
   vuejsDatepicker
  },
  data () {
    return {
      url : 'http://172.18.100.205/GestionBoutique/api/v1/',
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
      isNoQuantity : false,
      isLoadNego : false,
      isLoadDelete : false,
      isLoadNegoAnnuler : false,
      isLoadSaveMainButton : false,
      isLoadSaveMainButtonModal : false,
      isDecaissementExterne : false,
      isNoReturnedData : false,

      //SHOW BOOLEAN
      isStockIndicator : false,
      showAdvancedSearch : false,

      //VARIABLE LOAD DATE TABLE
      // isDataTableLoad :false,



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


      //VARIABLE FORM ADD ARTICLE
      code_article :"",
      nom_article :"",
      poids :"",
      description  :"",
      users_id : localStorage.u,

      //VARIABLE FORM ADD ARTICLE PRIX ARTICLE
      articles_id:"",
      type_prix:"",
      qte_decideur:"",
      prix_unitaire:"",

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

      avatarMain:"",
      fileMain :"",
      iduserToChangeProfile :"",

      //LOGIQUE SHOW OR HIDDEN BUTON SAVE AND UPDATE CONFIG PRICE ARTICLE,
      isAction : true,
      isShowBlocHistoFactureStatus : false,

      //SI CE DEPOT A DEJA LIVRER UNE PARTIE DE LA COMMANDE
      hasAlreadyDelivered : false




    }
  },

  created () {
    this._u_fx_to_load_router();
    this._u_get_code_facture();
    this._u_get_today();
    this._u_fx_get_montant();

    // alert(this.dpot_id);

    // console.log(this.detailTab.logic_article);
    // this._u_next_page(this._u_previous_page);
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
    get_article(){
      const newurl = this.url+"articles-get-all";
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              console.log(this.dataToDisplay);
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }
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
              // console.log(this.depotList);
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
    get_commande_facturier(statut=1){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/"+this.dateFilter+"/facturier";
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
    get_commande_caissier(statut=1){
      const newurl = this.url+"commandes-get-all/"+this.users_id+"/"+statut+"/"+this.dateFilter+"/caissier";
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
              this.isLoadSaveMainButtonModal = false;
            }).catch(error =>{
              console.log(error);
            })
    },
    get_commande_magazinier(statut=2){
      const newurl = this.url+"commandes-get-by-depot/"+this.dpot_id+"/"+statut+"/"+this.dateFilter+"/depot";
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
              // console.log(this.dataToDisplay);
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
                  this.get_commande_magazinier(2);
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
    get_commande_admin(statut=1){
      const newurl = this.url+"commandes-all-by-status/"+statut+"/"+this.dateFilter+"/status";
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
    get_decaisssement_externe(NoVariable=null){
      const newurl = this.url+"get-decaissement-externe-par-caissier/"+this.users_id+"/"+this.dateFilter;
      this.tabListData =[];
      this.isNoReturnedData = false;
      this.isDecaissementExterne = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.tabListData = response.data.data;
              if(this.tabListData.length < 1){
                this.isNoReturnedData = true;
              }
              this._u_fx_get_montant();
            }).catch(error =>{
              console.log(error);
            })
    },
    get_decaisssement_externe_admin(NoVariable=null){
      const newurl = this.url+"get-decaissement-externe-par-caissier/0/"+this.dateFilter;
      this.tabListData =[];
      this.isNoReturnedData = false;
      this.isDecaissementExterne = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.tabListData = response.data.data;
              if(this.tabListData.length < 1){
                this.isNoReturnedData = true;
              }
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
      const newurl = this.url+"approvisionnement-get-all/"+limit+"/"+offset;
      this.dataToDisplay=[];
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              this.dataToDisplay = response.data.data;
              if(this.dataToDisplay.length < 1){
                this.isNoReturnedData = true;
              }



              // console.log(this.dataToDisplay);
            }).catch(error =>{
              console.log(error);
            })
    },
    get_historique_approvisionnement_by_depot(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-get-by-depot/"+this.dpot_id+"/"+limit+"/"+offset;
      this.dataToDisplay=[];
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
            console.log(this.dataToDisplay);
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
                this.get_commande_facturier(4);
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
      const newurl = this.url+"approvisionnement-inter-depot-get-by-depot/"+this.dpot_id+"/"+limit+"/"+offset;
      this.dataToDisplay=[];
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
    get_historique_approvisionnement_inter_depot_admin(limit=this.PerPaged,offset=0, indexPage=0){
      const newurl = this.url+"approvisionnement-inter-depot-get-all/"+limit+"/"+offset;
      this.dataToDisplay=[];
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
    const depots = isFaveur == 1 ? this.depot_central_id : this.depots_id;
    const newurl = this.url+"articles-search-data-commande/"+this.codeArticle+"/"+this.qte+"/"+depots+"/"+isFaveur+"/search";
      if(this.depots_id ==""){
        this._u_fx_config_error_message_bottom("Message",['Veuillez selectionner un dépôt traiteur'],'alert-danger');
        return;
      }
      if(this.qte < 1){
        this._u_fx_config_error_message_bottom("Message",['La quantité doit être superieure à 1'],'alert-danger');
        return;
      }
      this.messageErrorBottom = false;
      this.isLoadSaveMainButtonModal = true;
      return axios
            .get(newurl,{headers: this.tokenConfig})
            .then(response =>{
              if(response.data.message.success !=null){
                response.data.data.isfaveur = isFaveur;
                this.tabListData.push(response.data.data);
                console.log(this.tabListData);
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

              // this._u_fx_field_multi_form_art();
            }).catch(error =>{
              console.log(error);
            })


    },
    _u_remove_line_list_art(index){

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
        const newurl = this.url+"articles-search-data-appro-inte-depot/"+this.codeArticle+"/"+this.qte+"/"+this.dpot_id+"/search";
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
    _u_open_mod_form(art,type, from=null){
      this._u_fx_form_init_field();
      this.type_prix = type;
      this.articles_id = art.id;
      this.isAction = true;
      if(from !=null){
        this.isAction = false;
        var typePrix = type;
        type = type == 1 ?'Gros':'Détail';
        this.modalTitle = "Modifier le prix de l'article "+art.nom_article+" en "+type;

        for (var i = 0; i < art.logic_detail_data.length; i++) {
          if(art.logic_detail_data[i].type_prix==typePrix){
            this.prix_unitaire = art.logic_detail_data[i].prix_unitaire;
            this.qte_decideur = art.logic_detail_data[i].qte_decideur;
          }
        }
        this.styleModal = 'block';
        console.log(this.isAction);
        return;
      }
      type = type == 1 ?'Gros':'Détail';
      this.modalTitle = "Fixer le prix de l'article "+art.nom_article+" en "+type;
      this.styleModal = 'block';

      console.log(this.isAction);
    },
    _u_close_mod_form(){
      this.styleModal = 'none';
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
    _u_open_mod_popup_caissier_principal_validation_decaissement(dec){
      console.log("===DECAI===");
      console.log(dec);
      this.modalTitle = "VALIDATION DE LA RECEPTION DU MONTANT "+dec.montant+" USD DE LE(LA) CAISSIER(E) "+dec.users_id_from.nom+" "+dec.users_id_from.prenom;
      this.decaissement_id = dec.id;
      this.styleModal = 'block';
    },
    _u_open_mod_popup_magaz(cmd,val){
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
      console.log(cmd);
    },
    _u_open_mod_popup_photo(userid){
      //console.log("=====ARTICLE=====");
      //console.log(cmd);
      this.modalTitle = "MODIFICATION DE LA PHOTO DU PROFILE";
      this.styleModal = 'block';
    },
    _u_get_today(){
      var currentDate = new Date();
      var currentDateWithFormat = new Date().toJSON().slice(0,10).replace(/-/g,'-');
      this.date_approvisionnement = currentDateWithFormat;
      this.date_vente = currentDateWithFormat;
    },
    _u_see_detail_tab(index){
      this.codeIdArticlePrint = index.id;
      this.detailTab = index;
      this.isShow = !this.isShow;

      //pour profile Image admin update
      this.iduserToChangeProfile = index.id;
      console.log(this.detailTab);
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
    _u_formatDateFilter(callbackFunction){
      var date = new Date(this.dateFilter);
      var month = date.getMonth()+1;
      this.dateFilter = date.getFullYear()+'-'+month+'-'+date.getDate();
      callbackFunction(this.stateStatus);
    },
    _u_formatOnlyDate(date){
      var date = new Date(this.dateFilter);
      var month = date.getMonth()+1;
      this.dateFilter = date.getFullYear()+'-'+month+'-'+date.getDate();
    },
    _u_formatOnlyDateAndReturn(date){
      var date = new Date(date);
      var month = date.getMonth()+1;
      return date.getFullYear()+'-'+month+'-'+date.getDate();
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

      this.articles_id = "";
      this.type_prix = "";
      this.qte_decideur = "";
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


      //CHAMPS APPROVISONNEMENT
      this.plaque = "";
      this.nom_chauffeur = "";
      this.num_chauffeur = "";
      this.num_bordereau ="";

      //CHAMPS APPRO INTER-Depot
      this.depots_id = "";



    },
    _u_fx_form_data_art(){
     var formData = new FormData();
     formData.append('code_article',vthis.code_article);
     formData.append('nom_article',vthis.nom_article);
     formData.append('description',vthis.description);
     formData.append('poids',vthis.poids);
     formData.append('users_id',vthis.users_id);
     return formData;
   },
    _u_fx_form_data_art_price(){
      var formData = new FormData();
      formData.append('articles_id',vthis.articles_id);
      formData.append('type_prix',vthis.type_prix);
      formData.append('prix_unitaire',vthis.prix_unitaire);
      formData.append('qte_decideur',vthis.qte_decideur);
      formData.append('users_id',vthis.users_id);
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
    _u_fx_to_load_router(){
    let pth = window.location.pathname.split('/');
    //pth = pth.split(',');
    console.log(pth);
    if(pth[2] ==='admin-add-article' || pth[2] ==='admin-list-article'){
      this.get_article();
    }
    if(pth[2] ==='admin-add-appro' || pth[2] ==='facturier-add-achat' || pth[2]==='caissier-add-achat' ||  pth[2]=='admin-add-users' || pth[2] === 'magaz-add-appro-to-depot'){
      this.get_depots();
    }
    if(pth[2]=='facturier-add-achat' || pth[2]==='caissier-add-achat'){
      this.get_caissiers();
      this.get_stock_depots();
    }
    if(pth[2]=='facturier-list-achat'){
      this.get_commande_facturier();
    }
    if(pth[2]=='caissier-list-achat'){
      this.get_commande_caissier();
    }
    if(pth[2]=='magaz-list-achat'){
      this.get_commande_magazinier();
    }
    if(pth[2]=='magaz-list-achat-faveur'){
      this.get_commande_faveur_magazinier();
    }
    if(pth[2]=='admin-list-achat'){
      this.get_commande_admin();
    }
    if(pth[2]=='admin-list-negotiation-achat'){
      this.get_commande_attente_negotiation();
      // this.get_caissier_main();
      this.get_caissiers();
    }
    if(pth[2]=='caissier-add-decaissement'){
      this.get_caissier_main();
      this.get_decaisssement_caissier_secondaire();
    }
    if(pth[2]=='caissier-list-decaissement'){
      this.get_decaisssement_caissier_principale();
    }
    if(pth[2]=='admin-histo-appro'){
      this.get_historique_approvisionnement();
    }
    if(pth[2]=='admin-stock'){
      this.get_stock_depots();
    }
    if(pth[2]=='admin-config-depot'){
      this.get_depots();
      this.get_users_admin(100000000000);
      // get_users_admin(limit=this.PerPaged,offset=0, indexPage=0)
    }
    if(pth[2]=='admin-config-etat-critique'){
      this.get_configuration_etat_critique();
    }
    if(pth[2]=='magaz-histo-appro'){
      this.get_historique_approvisionnement_by_depot();
    }
    if(pth[2]=='magaz-stock'){
      this.get_stock_depots_by_depot();
    }
    if(pth[2]=='admin-caisse'){
      this.get_caissiers();
    }
    if(pth[2]=='admin-decaissement'){
      this.get_decaisssement_histo_interne_admin();
    }
    if(pth[2]=='admin-add-users'){
      this.get_profiles();
    }
    if(pth[2]=='admin-list-users'){
      this.get_users_admin();
    }
    if(pth[2] == 'magaz-histo-appro-inter-depot'){
      this.get_historique_approvisionnement_inter_depot_by_depot();
    }
    if(pth[2] == 'admin-histo-appro-inter-depot'){
      this.get_historique_approvisionnement_inter_depot_admin();
    }






  }

  },
  watch : {
    messageError : function(val){
      console.log("change to "+this.messageError);
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
