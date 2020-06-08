/**
* frontプラグイン
* フロントサイドロジックをまとめる
* serviceを利用
* @namespace
* @class front
**/
;(function(root, undefined) {
	"use strict";
	var _unit_kb = 1024;
	var _unit_mb = _unit_kb*1024;
	var _unit_gb = _unit_mb*1024;

	var public_method ={
		getFormValue : getFormValue,
		clearFormValue : clearFormValue,
		validate : validate,
		validateFormValue : validateFormValue,
		showValidateError : showValidateError,
		clearValidateError : clearValidateError,
		inputAdjust	: inputAdjust,
		setInputAdjust : setInputAdjust
	};

	/**
	* 対象フォーム配下の入力要素値をJSONにて取得
	* input , textarea, select, checkbox:checked, radio:checked
	* ex . <input name="p1" value="xxx" /> → result[p1] = "xxx"
	* @method getFormValue
	* @param formId {String}
	* @return (JSON)
	*/
	function getFormValue(formId){
		var _req = {};
		$("input, textarea, select", $("#"+formId)).each(function(){
			var field = $(this).attr("name");
			if(field){
				if(field.indexOf("#")<0){
					var val = _getFormValue(this);
					_req[field] = val;
				}
			}
		});
		$("input[type=checkbox]:checked,input[type=radio]:checked", $("#"+formId)).each(function(){
			var field = $(this).attr("name");
			var val = _getFormValue(this);
			_req[field] = val;
		});
		return _req;
	}

	/**
	* selectorのvalueを取得
	* type=checkbox or, radio：checkedの場合値取得
	* multiple属性：(,)分割しarrayで取得
	* @private
	* @method _getFormValue
	* @param selector {String}
	* @return (String) selector.value
	*/
	function _getFormValue(selecter){
		var field = $(selecter).attr("name");
		var type = $(selecter).attr("type");
		var multiple = $(selecter).attr("multiple");
		var val = $(selecter).val();
		if(!util.isEmpty(multiple) && val.indexOf("|")>=0){
			var rows = val.split("|");
			val = [];
			for(var i=0,n=rows.length;i<n;i++){
				if(rows[i].indexOf(",")>=0) val.push(rows[i].split(","));
			}
		}
		if(!util.isEmpty(type) && (type == "checkbox" || type == "radio")){
			//TODO 2020.01.28 yasui type=radioでも値は配列でなければいけない？
			if(type=="checkbox" || type=="radio"){
				val = [];
				$("input[name='"+field+"']:checked").each(function() {
	        val.push($(this).val());
	      });
			}
			else {
				val = "";
				$("input[name='"+field+"']:checked").each(function() {
	        val = $(this).val();
	      });
			}
		}
		if(!util.isEmpty(multiple) && val.indexOf(",")>=0) val = val.split(",");
		return val;
	}
	/**
	* form配下の入力要素の値をクリアする
	* @method clearFormValue
	* @param formId {String}
	* @return {void} return nothing
	*/
	function clearFormValue(formId){
		clearValidateError();
		$("textarea, select", $("#"+formId)).val("");
		$("select.select2", $("#"+formId)).each(function(){
			$(this).val(-1).trigger('change');
		});
		$("input:not([type='hidden'])", $("#"+formId)).val("");
		$("input[type='checkbox'],input[type='radio']", $("#"+formId)).each(function(){
			$(this).val("");
			if($(this).iCheck){
				$(this).iCheck('uncheck');
			}
			$(this).change();
		});
	}
	/**
	* form配下の入力要素の値をチェックする
	* チェック方法は、validateを参照
	* @method validateFormValue
	* @param {String} formId
	* @return {Boolean} true(success) or false(failed)
	*/
	function validateFormValue(formId){
		var _isSuccess = true;
		var _messageCode = "E_VALIDATE_";
		clearValidateError(formId);
		$("input, textarea, select", $("#"+formId)).each(function(){
			var disabled = $(this).attr("disabled");
			if(!util.isEmpty(disabled)) return;
			var ret = validate(this, formId);
			if(!ret) {
				_isSuccess=false;
			}
		});
		if(!_isSuccess){
			$("html,body").animate({scrollTop:$('.error_message').parent().offset().top});
		}
		return _isSuccess;
	}
	/**
	* 入力要素の値をチェックし、
	* ＮＧの場合エラーメッセージを表示する
	* チェックルールは、DOM属性で設定する
	* @method validate
	* @example
	* var _validate = front.validate(selecter, formId);
	* @param selecter {Object}
	* @param formId {String}
	* @return {Boolean} true(success) or false(failed)
	*/
	/**
	* validate method target element
	*(validate rule)
	* @element input,select,textarea
	* @interface front.validate
	* @parents formId : DOM : <div id=[formId]><input name=...></div>
	* @attribute name (String)
	* validate時にnameの設定が必要
	* @attribute name (String)
	* validate時にnameの設定が必要
	* @attribute required (boolean)
	* 入力必須の場合、trueを指定
	* @attribute minlength {Int}
	* 文字列最小長
	* @attribute maxlength {Int}
	* 文字列最大長
	* @attribute minvalue {Int}
	* 入力最小値
	* @attribute maxvalue {Int}
	* 入力最大値
	* @attribute inputtype {String}
	* 　数値:number , 整数:integer, 小数:float
	* 　英字 : alpha, 英字大文字 : ualpha, 英字小文字 : lalpha
	* 　英数字 : alnum, 半角 : hankaku, 全角 : zenkaku
	*     全角カナ : zenkakukana, メールアドレス : email
	* @attribute equal {String}
	* name =equalで指定したフォームと値が一致しない場合エラー
	* @attribute equal_error {String}
	* equal エラー時に表示するメッセージ
	* @attribute equal {String}
	* name =equalで指定したフォームと値が一致しない場合エラー
	* @attribute equal_error {String}
	* equal エラー時に表示するメッセージ
	* @attribute less {String}
	* name =lessで指定したフォームより値が大きい場合エラー
	* @attribute less_error {String}
	* less エラー時に表示するメッセージ
	* @attribute greater {String}
	* name =greaterで指定したフォームより値が大きい場合エラー
	* @attribute greater_error {String}
	* greater エラー時に表示するメッセージ
	* @attribute query_check {String}
	* query_checkで指定したクエリを実行、値がクエリ実行結果に存在しない場合エラー
	* @attribute query_check_error {String}
	* query_check エラー時に表示するメッセージ
	* @attribute query_check_nodata {Boolean}
	* trueの場合、query_check により、値が存在する場合をエラーとする
	*/
	function validate(selecter, formId){
		var _isSuccess = true;
		var _isHidden = $(selecter).is(":hidden");
		if(_isHidden) return _isSuccess;
		var val = $(selecter).val();
		if(selecter.tagName=="SELECT"){
		 	if(util.isEmpty(val)) val = "";
		}
		else{
			if(util.isEmpty(val)) val = $(selecter).text();
		}
		var vallen = (val+"").length;
		var name = $(selecter).attr("name");
		var type = $(selecter).attr("type");
		var uitype = $(selecter).attr("uitype");
		var minlength = $(selecter).attr("minlength");
		var maxlength = $(selecter).attr("maxlength");
		var minvalue = $(selecter).attr("minvalue");
		var maxvalue = $(selecter).attr("maxvalue");
		var required = $(selecter).attr("required");
		var inputtype= $(selecter).attr("inputtype");
		var accesskey= $(selecter).attr("accesskey");
		var equal= $(selecter).attr("equal");
		var equal_error= $(selecter).attr("equal_error");
		var not_equal= $(selecter).attr("not_equal");
		var not_equal_error= $(selecter).attr("not_equal_error");
		var less= $(selecter).attr("less");
		var less_error= $(selecter).attr("less_error");
		var greater= $(selecter).attr("greater");
		var greater_error= $(selecter).attr("greater_error");
		var query_check= $(selecter).attr("query_check");
		var query_check_nodata= $(selecter).attr("query_check_nodata");
		var query_check_error= $(selecter).attr("query_check_error");

		var messageCode = "";
		var messageParam = "";
		var isfile = false;
		var isscan = false;
		var _filesize = 0;
		if(type=="file"){
			if($(selecter).fileUI){
				var _file = $(selecter).fileUI("getFile");
				val = _file.name;
				_filesize = _file.sizeVal;
			}
			else {
				val = $(selecter).val();
				_filesize = util.getFileSize($(selecter), false);
			}
		}

		if((type=="radio" || type=="checkbox") && !util.isEmpty(required)){
			if($("input[name='"+name+"']:checked").length==0){
				_isSuccess = false;
				messageCode = "REQ";
			}
		}

 		if(selecter.tagName=="SELECT" && !util.isEmpty(required)){
			if(val==""){
				_isSuccess = false;
				messageCode = "REQ";
			}
 		}

 		if(!util.isEmpty(required) && util.isEmpty(val)){
 			//必須入力不正
 			_isSuccess = false;
 			messageCode = "REQ";
 		}
 		if(!util.isEmpty(accesskey) && accesskey=="scan"){
 			isscan = true;
 		}
 		else if(!util.isEmpty(type) && type=="file"){

 			 isfile = true;
 			//ファイル入力系のチェック
 			if(!util.isEmpty(maxlength)){
 				var _maxfilesize = (maxlength|0)*_unit_mb;
 				if(_maxfilesize > 0 && _filesize > _maxfilesize){
 					_isSuccess = false;
 					messageCode = "FLS";
 					messageParam=maxlength;
 				}
 			}
 		}

 		if(_isSuccess && !isscan && !isfile && !util.isEmpty(val)){
 			//scan ,fileの場合は文字系のチェックはしない
 			//主に文字入力系のチェック
 			if(!util.isEmpty(minlength) && vallen<minlength){
 				//必要文字数未満
 				_isSuccess = false;
 				messageCode = "MINL";
 				messageParam = minlength;
 				if(!util.isEmpty(maxlength) && maxlength==minlength){
 					messageCode = "EQL";
 					messageParam=minlength;
 				}
 				else if(!util.isEmpty(maxlength)){
 					messageCode = "RNGL";
 					messageParam=minlength+"|"+maxlength;
 				}
 			}
 			else if(!util.isEmpty(maxlength) && vallen>maxlength){
 				//文字数超過
 				_isSuccess = false;
 				messageCode = "MAXL";
 				messageParam=maxlength;
 				if(!util.isEmpty(maxlength) && maxlength==minlength){
 					messageCode = "EQL";
 					messageParam=minlength;
 				}
 				else if(!util.isEmpty(minlength)){
 					messageCode = "RNGL";
 					messageParam=minlength+"|"+maxlength;
 				}
 			}
 			else if(!util.isEmpty(uitype) && uitype=="datepicker" && !util.isDate(val)){
 				//日付チェック
 				_isSuccess = false;
 				messageCode = "YMD";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="number" && !$.isNumeric(val)){
 				//数字チェック
 				_isSuccess = false;
 				messageCode = "NUM";
 			}
 			else if(!util.isEmpty(uitype) && inputtype=="integer" && !util.isInteger(val)){
 				//整数チェック
 				_isSuccess = false;
 				messageCode = "INT";
 			}
 			else if(!util.isEmpty(uitype) && inputtype=="float" && !util.isFloat(val)){
 				//小数チェック
 				_isSuccess = false;
 				messageCode = "FLT";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="alpha" && !util.isAlpha(val)){
 				//英字チェック
 				_isSuccess = false;
 				messageCode = "ALP";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="ualpha" && !util.isAlpha(val,true,false)){
 				//英字チェック(大文字のみ）
 				_isSuccess = false;
 				messageCode = "ALPU";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="lalpha" && !util.isAlpha(val,false,true)){
 				//英字チェック（小文字のみ）
 				_isSuccess = false;
 				messageCode = "ALPL";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="alnum" && !util.isAlphanumeric(val)){
 				//英数字チェック
 				_isSuccess = false;
 				messageCode = "ALN";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="hankaku" && !util.isHankaku(val)){
 				//半角チェック
 				_isSuccess = false;
 				messageCode = "HAN";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="zenkaku" && !util.isZenkaku(val)){
 				//全角チェック
 				_isSuccess = false;
 				messageCode = "ZEN";
 			}
 			else if(!util.isEmpty(inputtype) && inputtype=="zenkakukana" &&	 (!util.isZenkaku(val) || !util.isKana(val))){
 				//全角カナチェック
 				_isSuccess = false;
 				messageCode = "ZKANA";
 			}
			else if(!util.isEmpty(inputtype) && inputtype=="email" && !util.isMail(val)){
 				//メール形式チェック
 				_isSuccess = false;
 				messageCode = "EML";
 			}
			else if(!util.isEmpty(inputtype) && inputtype=="json" && !util.isJson(val)){
 				//JSON形式チェック
 				_isSuccess = false;
 				messageCode = "JSON";
 			}

			if(!util.isEmpty(minvalue) && util.diffVal(val, minvalue)<0){
 				//数値未満
 				_isSuccess = false;
				if(util.isDate(val)){
					messageCode = "MINDV";
				}
				else {
					messageCode = "MINV";
				}
 				messageParam=minvalue;
 				if(!util.isEmpty(maxvalue)){
 					messageCode = "RNGV";
 					messageParam=minvalue+"|"+maxvalue;
 				}
 			}
 			else if(!util.isEmpty(maxvalue)  && util.diffVal(val, maxvalue)>0){
 				//数値超過
 				_isSuccess = false;
				if(util.isDate(val)){
					messageCode = "MAXDV";
				}
				else {
					messageCode = "MAXV";
				}
 				messageParam=maxvalue;
 				if(!util.isEmpty(minvalue)){
 					messageCode = "RNGV";
 					messageParam=minvalue+"|"+maxvalue;
 				}
 			}
 		}
 		if(messageCode!="") messageCode = ""+messageCode;
 		if(_isSuccess){
 			if(!util.isEmpty(equal) && !util.isEmpty($("[name='"+equal+"']", $("#"+formId)).val())
 				 && val != $("[name='"+equal+"']", $("#"+formId)).val()){
 				//値が一致するかチェック、対象値と一致しない場合エラーとする
 				_isSuccess = false;
 				messageCode = equal_error;
 				messageParam=val+"|"+ $("[name='"+equal+"']", $("#"+formId)).val();
 			}
			if(!util.isEmpty(not_equal) && !util.isEmpty($("[name='"+not_equal+"']", $("#"+formId)).val())
 				 && val == $("[name='"+not_equal+"']", $("#"+formId)).val()){
 				//値が一致するかチェック、対象値と一致する場合エラーとする
 				_isSuccess = false;
 				messageCode = not_equal_error;
 				messageParam=val+"|"+ $("[name='"+not_equal+"']", $("#"+formId)).val();
 			}
 			if(!util.isEmpty(less) && !util.isEmpty($("[name='"+less+"']", $("#"+formId)).val())
 				 && util.diffVal(val, $("[name='"+less+"']", $("#"+formId)).val())>0){
 				//値が小さいかチェック、対象値より大きい場合エラーとする
 				_isSuccess = false;
 				messageCode = less_error;
 				messageParam=val+"|"+ $("[name='"+less+"']", $("#"+formId)).val();
 			}
 			if(!util.isEmpty(greater) && !util.isEmpty($("[name='"+greater+"']", $("#"+formId)).val())
 				 && util.diffVal(val, $("[name='"+greater+"']", $("#"+formId)).val())<0){
 				//値が大きいかチェック、対象値より小さい場合エラーとする
 				_isSuccess = false;
 				messageCode = greater_error;
 				messageParam=val+"|"+ $("[name='"+greater+"']", $("#"+formId)).val();
 			}
 			if(!util.isEmpty(query_check)){
				var _isExists = false;
 				service.getAjax(false, "/"+query_check+"/"+val, null,
 					function(result, st, xhr) {
						if(result["status"]===200){
							_isExists = true;
						}
 					},
 					function(xhr, st, err) {
						if(xhr.responseJSON["status"]!==404){
							_isSuccess = false;
							messageCode = "error";
							messageParam= "validate/querycheck\n"+err.message+"\n"+xhr.responseText;
						}
 					}
 				);
				if(_isExists && util.isEmpty(query_check_nodata)){
					//データが存在する場合エラー
					_isSuccess = false;
					messageCode = query_check_error;
					messageParam=val+"|";
				}
				else if(!_isExists && !util.isEmpty(query_check_nodata)){
					//データが存在しない場合エラー
					_isSuccess = false;
					messageCode = query_check_error;
					messageParam=val+"|";
				}
 			}
 		}
		if(!_isSuccess) showValidateError(selecter, messageCode, messageParam);
		var validate = $(selecter).attr("validate");
		if(!util.isEmpty(validate)){
			return eval(validate);
		}
		return _isSuccess;
	}
	/**
	* 入力要素にエラーメッセージブロックを追加する
	* @method showValidateError
	* @param selecter {Object}
	* @param messageCode {String}
	* @param [messageParam] {String}
	* @return {void} return nothing
	*/
	function showValidateError(selecter, messageCode, messageParam){
		var message = service.getMessage(messageCode, messageParam);
		if(!util.isEmpty(message) && message["body"] && !util.isEmpty(message["body"])){
			_showValidateError(selecter, message["body"]);
		}
	}
	/**
	* 入力要素にエラーメッセージブロックを追加する
	* @method _showValidateError
	* @private
	* @param selecter {Object}
	* @param body {String}
	* @return {void} return nothing
	*/
	function _showValidateError(selecter, error_message){
		var field = $(selecter).attr("name");
		if(field)	field = field.replace_all('[]', '');
		else field = 'no_name';
		var tag = $(selecter).prop("tagName");
		var type = $(selecter).attr("type");
		var _errTemplate = '<div class="row m-2 error_message" id="error'+field+'"><p class="small text-danger">#message#</p></div>';
		if($("#error"+field).length) return;
		var message = _errTemplate.replace("#message#", error_message);
		if(type=="radio" || type=="checkbox"){
			$(selecter).parent().parent().parent().append(message);
		}
		else {
			$(selecter).parent().parent().append(message);
		}
	}
	/**
	* 対象フォームのエラーメッセージブロックをすべて除去する
	* @method clearValidateError
	* @private
	* @param formId {String}
	* @return {void} return nothing
	*/
	function clearValidateError(formId){
		if(util.isEmpty(formId)) formId = "form";
		else if(formId.substr(0,1)!="#") formId="#"+formId;
		$(".error_message", $(formId)).remove();
	}

	/**
	* inputtype指定があるテキストフォームにinputAdjustをonblurイベントに設定する
	* @method setInputAdjust
	* @param formId {String}
	* @return {void} return nothing
	*/
	function setInputAdjust(formId){
		$("input[type=text],input[type=tel],textarea", $("#"+formId)).each(function(){
			var inputtype = $(this).attr("inputtype");
			var accesskey = $(this).attr("accesskey");
			var isInputAdjust = true;
			if(util.isEmpty(inputtype)) isInputAdjust = false;
			if(isInputAdjust){
				$(this).unbind("blur");
				$(this).on("blur", function(e){
					var inputtype = $(this).attr("inputtype");
					var minl = $(this).attr("minlength");
					var maxl = $(this).attr("maxlength");
					var val = $(this).val();
					val = inputAdjust(val, maxl, minl, inputtype);
					$(this).val(val);
				});
			}
		});
	}

	/**
	* inputtypeにより、対象入力値以外を変換・除去を行い返す
	* @method inputAdjust
	* @param val {String}
	* @param [maxl] {Int}
	* @param [minl] {Int}
	* @param inputtype {String}
	* @return {void} return nothing
	*/
	function inputAdjust(val, maxl, minl, inputtype){
		if(inputtype!="zenkaku" && inputtype!="zenkakukana"
			&& inputtype!="json" && inputtype!="sql"){
			//半角変換
			val = util.convHankaku(val);
		}
		switch(inputtype){
			case "integer" :
				val = val.replace(/[^0-9]/g, '');
				break;
			case "number" :
				val = val.replace(/[^0-9]/g, '');
				break;
			case "alpha" :
				val = val.replace(/[^a-zA-Z]/g, '');
				break;
			case "ualpha" :
				val = val.replace(/[^A-Z]/g, '');
				break;
			case "lalpha" :
				val = val.replace(/[^a-z]/g, '');
				break;
			case "alnum" :
				val = val.replace(/[^a-zA-Z0-9]/g, '');
				break;
			case "hankaku" :
				//半角変換のみ
				break;
			case "email" :
				//半角スペースは除外
				val = val.replace_all(" ", "");
				break;
			case "zenkaku" :
				val = util.convZenkaku(val);
				break;
			case "zenkakukana" :
				if(util.isKana(val) && util.isHankaku(val)) val= util.convZenkakuKana(val);
				if(util.isHiragana(val) && util.isZenkaku(val)) val= util.convZenkakuHiraganaToKana(val);
				break;
			case "date" :
				if(!util.isDate(val)) val = "";
				break;
			case "json" :
				if(!util.isJson(val) && util.isJson("{"+val+"}")) val = "{"+val+"}";
				break;
		}
		if(inputtype=="integer"){
			if(util.isEmpty(val)) val="0";
			if(!util.isEmpty(maxl) && maxl>1) val = util.leftPadZero(val,maxl);
		}

		if(!util.isEmpty(maxl) && maxl>0 && val.length > maxl) val = (val+"").substring(0, maxl);
		return val;
	}
	root.front = $.extend({}, root.front, public_method);

})(this);
