/**
* web-apiプラグイン
* サーバーサイドと通信するロジックをまとめる
* domを利用
* @namespace
* @class service
**/
;(function(root, undefined) {
	"use strict";
	var _loadTimer = null;
	var _loading = null;
	var _requestCache = {};
	var _cache = {};
	_cache["userSetting"] = {
		"loadingStart" : 1,
		"requestCacheTime" : 300000,
		"requestCacheSize" : 30
	};

	//list_table用のIF
	var _isDebug = false;
	var public_method = {
		//ページコード=URL
		setQueryParam : setQueryParam,
		getQueryParam : getQueryParam,
		getGroupData : getGroupData,
		getCodeData : getCodeData,
		getMessage  : getMessage ,
		getEncodeString : getEncodeString,
		getDecodeString : getDecodeString,
		loadClose : loadClose,
		logout : _logout,
		getAjax  : getAjax,
		postAjax : postAjax,
		uploadAjax : uploadAjax,
    downloadAjax : downloadAjax,
		fileDownload : fileDownload,
		extendRequestJson  : extendRequestJson,
		error : errorMessage,
		alert : alertMessage,
		confirm : confirmMessage,
		clearRequestCache : clearRequestCache
	};
	var _callback = null;
	var _message = {
		"C_POST_INS" : {"title" : "登録確認", "body": "登録しますが、よろしいですか？"},
		"C_POST_UPD" : {"title" : "更新確認", "body": "更新しますが、よろしいですか？"},
		"C_POST_DEL" : {"title" : "削除確認", "body": "削除しますが、よろしいですか？"},
		"C_POST_IMP" : {"title" : "ファイル取込", "body": "ファイルインポートを開始しますが、よろしいですか？"},
		"C_POST_EXP" : {"title" : "ファイル出力", "body": "出力ファイルをダウンロードしますが、よろしいですか？"},
		"C_POST_UPL" : {"title" : "ファイルアップロード", "body": "ファイルアップロードしますが、よろしいですか？"},
		"E_ERROR" : {"title" : "システムエラー", "body" : "管理者にお問い合わせください" },
		"REQ" :{"title" : "入力エラー", "body": "入力してください"},
		"FLS" :{"title" : "入力エラー", "body": "{%0}MBを超えるファイルは添付できません"},
		"MINL" :{"title" : "入力エラー", "body": "{%0}文字以上で入力してください"},
		"MAXL" :{"title" : "入力エラー", "body": "{%0}文字以下で入力してください"},
		"EQL" :{"title" : "入力エラー", "body": "{%0}文字で入力してください"},
		"RNGL" :{"title" : "入力エラー", "body": "{%0}文字～{%1}文字で入力してください"},
		"MINV" :{"title" : "入力エラー", "body": "{%0}以上で入力してください"},
		"MAXV" :{"title" : "入力エラー", "body": "{%0}以下で入力してください"},
		"MINDV" :{"title" : "入力エラー", "body": "{%0}以降で入力してください"},
		"MAXDV" :{"title" : "入力エラー", "body": "{%0}以前で入力してください"},
		"RNGV" :{"title" : "入力エラー", "body": "{%0}～{%1}の範囲で入力してください"},
		"NUM" :{"title" : "入力エラー", "body": "数字で入力してください"},
		"INT" :{"title" : "入力エラー", "body": "数字で入力してください"},
		"FLT" :{"title" : "入力エラー", "body": "小数で入力してください"},
		"ALP" :{"title" : "入力エラー", "body": "半角英字で入力してください"},
		"ALPL" :{"title" : "入力エラー", "body": "アルファベット小文字で入力してください"},
		"ALPU" :{"title" : "入力エラー", "body": "アルファベット大文字で入力してください"},
		"ALN" :{"title" : "入力エラー", "body": "半角英数で入力してください"},
		"HAN" :{"title" : "入力エラー", "body": "半角で入力してください"},
		"ZEN" :{"title" : "入力エラー", "body": "全角で入力してください"},
		"ZKANA" :{"title" : "入力エラー", "body": "全角カナで入力してください"},
		"EML" :{"title" : "入力エラー", "body": "メール形式が正しくありません"},
		"YMD" :{"title" : "入力エラー", "body": "日付形式が正しくありません"},
		"JSON" :{"title" : "入力エラー", "body": "JSON形式が正しくありません"},
	}
	//クロージャー
	/**
	* 初期処理 :
	* リクエスト処理用のパラメータの読み込み、groupcodeをキャッシュ
    * @private
    * @method startProc
    * @return {void} return nothing
    */
	function startProc(){
		var data = util.getLocalData("userSetting");
		if(!util.isEmpty(data)){
			for(var key in _cache["userSetting"]){
				if(!util.isEmpty(data[key])) continue;
				_cache["userSetting"][key] = data[key];
			}
		}
		$('#loading').on('shown.bs.modal', function () {
			if(util.isFunction(_callback)){
				_callback();
			}
    });
		loadRequestCache();
	}
	/**
	* ローディングダイアログを表示する
    * @private
    * @method loadOpen
    * @return {void} return nothing
    */
	function loadOpen (){
		console.log("loadOpen");

		$("#loading").modal('show');
		return;
	}
	/**
	* ローディングダイアログを閉じる
    * @private
    * @method loadClose
    * @return {void} return nothing
    */
	function loadClose (){
		console.log("loadClose");
		_callback = null;
		$("#loading").modal('hide');
		if(_loadTimer!=null){
			clearTimeout(_loadTimer);
			_loadTimer = null;
		}
		return;
	}

	/**
    * ログアウト処理
	*  ブラウザストレージをクリアし、logoutに遷移
    * @method logout
    * @return {void} return nothing
    */
	function _logout(){
		if(!_isDebug) {
			util.clearLocalData();
			location.href = "/logout";
		}
	}

	/**
    * URLパラメータ設定
	* https://domain?p1=a&p2=b&p3=c
	* cache = { "p1": "a", "p2" : "b", "p3" : "c"}
    * @method setQueryParam
    * @return {void} return nothing
    */
	function _setQueryParam(){
		var _urls = (document.URL+"").split('/');
		var _pageCode = _urls[_urls.length-1].replace("#","");
		//urlからページコード取得
		_cache["_query_"] = {};
		var queryParam = ($(location).attr("search")+"&").split("&");
		_pageCode = _pageCode.replace('"',"");
		_pageCode = _pageCode.replace(/\?.*$/,"");
		for(var i=0,n=queryParam.length;i<n;i++){
			if(queryParam[i].indexOf("=")<0) continue;
			var q = queryParam[i].split("=");
			if(q.length!=2) continue;
			if(q[0].substring(0,1)=="?") q[0] = q[0].substring(1, q[0].length);
			_cache["_query_"][q[0]]=q[1];
		}
		_cache["page"] = _pageCode;
		var h = getQueryParam("h");
		if(!util.isEmpty(h)) _cache["h0"] = h;
		return {"page" : _cache["page"], "h" : h, "query" : _cache["_query_"]};
	}
	function setQueryParam(param){
		_setQueryParam();
		for(var key in param){
			_cache["_query_"][key] = param[key];
		}
		return getUrl();
	}
	function getUrl(){
		var _url = _cache["page"]+"?";
		for(var key in _cache["_query_"]){
			if(util.isEmpty(_cache["_query_"][key])) continue;
			_url+=key+"="+_cache["_query_"][key]+"&";
		}
		_url = _url.substring(0, _url.length-1);
		if(!util.isEmpty(_cache["h0"])){
			_url += "#"+_cache["h0"];
		}
		return _url;
	}
	/**
    * URLパラメータ取得
	* キャッシュしたURLパラメータより値を取得
    * @method getQueryParam
	* @param name {String}
    * @return {String} _cache["_query"_][name]
    */
	function getQueryParam(name){
		var ret = decodeURI(_cache["_query_"][name]);
		if(ret==="undefined") return "";
		if(util.isEmpty(ret)) return "";
		return ret;
	}
	/**
	* base64デコード
	* base64文字列をutf8にデコード
    * @method getDecodeString
	* @param str {String} (base64)
    * @return (utf8)
    */
	function getDecodeString(str){
		if(util.isEmpty(str)) return "";
		var res = str.replace_all( ":eq:", "=");
		res = res.replace_all(":amp:", "&");
		res = res.replace_all(":sl:", "/");
		res = res.replace_all(":hash:", "#");
		res = base64decode(res);
		res = utf8to16(res);
		return res;
	}
	/**
	* base64エンコード
	* utf8文字列をbse64形式にエンコード
    * @method getEncodeString
	* @param str {String} (utf8)
    * @return {String} (base64)
    */
	function getEncodeString(str){
		if(util.isEmpty(str)) return "";
		var res = utf16to8(str);
		res = base64encode(res);
		res = res.replace_all("=", ":eq:");
		res = res.replace_all("&", ":amp:");
		res = res.replace_all("/", ":sl:");
		res = res.replace_all("#", ":hash:");
		return res;
	}
	/**
	* 汎用グループ・汎用コード設定
	* システムで共通利用する汎用グループ・コードを取得
	* JSON形式でクロージャにキャッシュ
	*またブラウザストレージにキャッシュしリクエストを削減する
    * @method setGroupCode
    * @return {void} return nothing
    */
		function setGroupCode(){
			if(util.isEmpty(_cache["GROUP_CODE"]) || util.isEmpty(_cache["GROUP"])){
				var ret = getAjax(false, "/getgroupcode", {},
					function(result, st, xhr) {
						_cache["GROUP"] = [];
						_cache["GROUP_CODE"] = {};
						var data =  result["data"];
						if(data && data.length >=0){
							var count = data.length;
							for(var i=0;i<count;i++){
								var group = data[i]["GROUP_VAL"];
								var gname = data[i]["GROUP_NAME_ENC"];
								if(_cache["GROUP"].length<1 || _cache["GROUP"][_cache["GROUP"].length-1][0]!=group){
									_cache["GROUP"].push([group, gname]);
								}
								var code = data[i]["CODE_VAL"];
								var cname = data[i]["CODE_NAME_ENC"];
								var cremark = data[i]["CODE_REMARK_ENC"];
								var pgroup = data[i]["PARENT_GROUP"];
								var pcode = data[i]["PARENT_CODE"];
								if(!_cache["GROUP_CODE"][group]) {
									_cache["GROUP_CODE"][group] = {};
									_cache["GROUP_CODE"][group]["name"] = gname;
									_cache["GROUP_CODE"][group]["code"] = [];
								}
								_cache["GROUP_CODE"][group]["code"].push([code, cname, cremark, pgroup,pcode]);
							}
						}
					},
					function(xhr, st, err) {
						alert("getGroupCode\n"+err.message+"\n"+xhr.responseText);
					}, true
				);
			}
		}

	/**
	* 汎用グループ取得
	* [["group_code", "groupname"],
	* ["group_code", "groupname"],
	* ["group_code", "groupname"]]
    * @method getGroupData
    * @return {Array}
    */
	function getGroupData(){
		var _result = [];
		for(var i=0, n=_cache["GROUP"].length;i<n;i++){
			_result.push([_cache["GROUP"][i][0], getDecodeString(_cache["GROUP"][i][1])]);
		}
		return _result;
	}
	/**
	* 汎用コード取得
	* グループ配下のコードをすべて取得
    * @method getCodeData
	* @param groupval {String}
    * @return {Array} ["code_val", "code_name", "code_remark"],["code_val", "code_name", "code_remark"]..
    */
	/**
	* 汎用コード取得
	* コード（単一）の情報を取得
    * @method getCodeData
	* @param groupval {String}
	* @param codeval {String}
    * @return {Array} ["code_val", "code_name", "code_remark"]
    */
	function getCodeData(groupval, codeval){
		if(util.isEmpty(groupval)) return null;
		if(!_cache["GROUP_CODE"][groupval]) return null;
		var _result = [];

		if(util.isEmpty(codeval)){
			//return _cache["GROUP_CODE"][groupval]["code"];
			for(var i=0,n=_cache["GROUP_CODE"][groupval]["code"].length;i<n;i++){
				var _codeval = _cache["GROUP_CODE"][groupval]["code"][i][0];
				_result.push(getCodeData(groupval,_codeval));
			}
			return _result;
		}
		else {
			for(var i=0,n=_cache["GROUP_CODE"][groupval]["code"].length;i<n;i++){
				if(codeval == _cache["GROUP_CODE"][groupval]["code"][i][0]){
					for(var j=0, m=_cache["GROUP_CODE"][groupval]["code"][i].length;j<m;j++){
						var _val = _cache["GROUP_CODE"][groupval]["code"][i][j];
						if(j==1 || j==2) {
							//CODE_NAME , CODE_REMARKの場合
							_val = getDecodeString(_val);
						}
						_result.push(_val);
					}
					return _result;
				}
			}
		}
		return null;

	}
	/**
	* メッセージデータ取得
	  * @method getMessage
	* @param msgCode {String}
	* @param [param] {String}
    * @return {JSON} {"title" : "messageTitle", "body" : "messageBody"}
    */
	function getMessage(msgCode, param){
		var p = param;
		//paramが文字列 p0|p1|p2の場合 、[p0.p1.p2]とする
		if(!util.isEmpty(param) && typeof param == "string") p = (param+"|").split("|");
		var title = "";
		var body = "";
		if(util.isHankaku(msgCode) && _message[msgCode]){
			title = _message[msgCode]["title"];
			body = _message[msgCode]["body"];
		}
		else {
			//メッセージコードではない場合
			body = msgCode;
			title = "";
		}
		if(p){
			for(var i=0,n=p.length;i<n;i++){
				if(body.indexOf("{%")<0) break;
				body = body.replace("{%"+i+"}", p[i]);
			}
		}
		return {"title":title, "body": body};
	}

	//---------------------------------------------------
	//ajax処理系～
	//---------------------------------------------------
	/**
	* Ajax GET Method
	* 実行途中はloadingを表示する
	* リクエストに応じて結果をキャッシュする
    * @method getAjax
	* @param [async] {Boolean}  同期処理とする場合:True
	* @param url {String}
	* @param request {JSON}
	* @param success {Function}  成功時コールバック関数
	* @param error {Function}  エラー時コールバック関数
	* @param [cacheReset] {Boolean}
    * @return {Object} defferd
    */
	function getAjax(async,url, request, success, error, cacheReset){
		var _request = requestDataParse(request);
		var auth = util.getLocalData("auth");
		var key = url+JSON.stringify(_request);
		var now = +new Date();

		if(cacheReset){
			delete _requestCache[key];
		}
		else {
			var _result = getRequestCache(key);
			if(_result !== null){
				if(util.isFunction(success)) success(_result, null,null);
				return true;
			}
		}
		console.log("getAjax exec:"+key);
		_callback = function(){
			var ret = $.ajax({
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				async: async,
				cache: !cacheReset,
				dataType: "JSON",
				url: (url),
				data: (_request)
			}).done(
				function(result, st, xhr) {
					//loadClose();
					loadClose();
					if(result["status"]==200){
						if(util.isFunction(success)) success(result, st, xhr);
						setRequestCache(key, result);
					}
					else {
						alertMessage(result["message"], result["description"], _logout);
						//10秒経過で自動ログアウト
						setTimeout(_logout, 10000);
					}
				}
			).
			fail(
				function(xhr, st, err) {
					loadClose();
					if(util.isFunction(error)) error(xhr, st, err);
				}
			);
			return ret;
		};
		if(_request['loading'] && _request['loading']==true){
			loadOpen();
		}
		else {
			_callback();
		}
	}
	/**
	* Ajax POST Method
	* 実行途中はloadingを表示する
    * @method postAjax
	* @param url {String}
	* @param request {JSON}
	* @param success {Function}  成功時コールバック関数
	* @param error {Function}  エラー時コールバック関数
    * @return {Object} defferd
    */
	function postAjax(url, request, success, error, _type){
		var auth = util.getLocalData("auth");
		console.log("postAjax exec:"+url);
		var _request = requestDataParse(request);
		if(util.isEmpty(_type)) _type="POST";
		_callback = function(){
			var ret = $.ajax({
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: _type,
				cache: false,
				dataType: "JSON",
				url: (url),
				data: (_request)
			}).done(
				function(result, st, xhr) {
					loadClose();
					_requestCache = [];
					if(util.isFunction(success)) success(result, st, xhr);
				}
			).
			fail(
				function(xhr, st, err) {
					loadClose();
					if(util.isFunction(error)) error(xhr, st, err);
				}
			);
			return ret;
		};
		if(_request['loading'] && _request['loading']==true){
			loadOpen();
		}
		else {
			_callback();
		}
	}
	/**
	* Ajax FileUpload Method
	* 実行途中はloadingを表示する
    * @method uploadAjax
	* @param url {String}
	* @param request {JSON}
	* @param success {Function}  成功時コールバック関数
	* @param error {Function}  エラー時コールバック関数
	* @param loading {Function}  アップロード中コールバック関数
    * @return {void} return nothing
    */
	function uploadAjax(url, request,  success, error, loading){
		var _request = requestDataParse(request);
		_callback = function(){
			var ret=$.ajax({
				url: (url),
				data : _request,
				type: "POST",
				contentType:false,
				processData: false,
				cache: false,
				xhr: function() {
					var xhrobj = $.ajaxSettings.xhr();
					if (xhrobj.upload) {
							xhrobj.upload.addEventListener('progress', function(event) {
								if(util.isFunction(loading)) loading(event);
							}, false);
					}
					return xhrobj;
				},
				success: function(result, st, xhr) {
					loadClose();
					_cache["_uploadFiles"] = {};
					if(util.isFunction(success)) success(result, st, xhr);
				},
				error: function(xhr, st, err) {
					loadClose();
					_cache["_uploadFiles"] = {};
					if(util.isFunction(error)) error(xhr, st, err);
				}
			});
		};
		if(_request['loading'] && _request['loading']==true){
			loadOpen();
		}
		else {
			_callback();
		}
	}
	//ajax file download
	/**
	* Ajax FileDownload Method
	* 実行途中はloadingを表示する
    * @method downloadAjax
	* @param url {String}
	* @param request {JSON}
	* @param success {Function}  成功時コールバック関数
	* @param error {Function}  エラー時コールバック関数
    * @return {void} return nothing
    */
	function downloadAjax(url, request,  success, error){
		var _request = requestDataParse(request);
		_callback = function(){
			var ret = $.ajax({
				headers: {'X-Requested-With': 'XMLHttpRequest'},
				secureuri:false,
				type: "GET",
				async: false,
				cache: false,
				url: url,
				dataType: "JSON",
				data: (_request)
			}).done(
				function(result, st, xhr) {
					loadClose();
					if(result["status"]==200){
						if(!util.isEmpty(result.url)){
							if(util.isFunction(success)) success(result, st, xhr);
						}
						else {
							alertMessage(result["message"], result["description"], null);
						}
					}
					else {
						alertMessage(result["message"], result["description"], null);
					}
				}
			).
			fail(
				function(xhr, st, err) {
					loadClose();
					if(util.isFunction(error)) error(xhr, st, err);
				}
			);
		};
		if(_request['loading'] && _request['loading']==true){
			loadOpen();
		}
		else {
			_callback();
		}
	}

	//filedownload usage hidden frame
	/**
	* fileDownload Method
	* hidden frameを利用し、POSTでファイルダウンロードする
	*
    * @method fileDownload
	* @param url {String}
    * @return {void} return nothing
    */
	function fileDownload(url) {
		var fileDownloadFrame = util.getFileName(url)+'frame',
		iframe = document.getElementById(fileDownloadFrame);
		if (iframe === null) {
			iframe = document.createElement('iframe');
			iframe.id = fileDownloadFrame;
			iframe.style.display = 'none';
			document.body.appendChild(iframe);
		}
		iframe.src = url;
	};

	/**
	*  JSONパラメータ拡張
	*  JSONパラメータa にbの要素を追加する
    * @method extendRequestJson
	* @param a {JSON}
	* @param b {JSON}
	* @param [overwrite] {Boolean}  trueの場合、必ずbを設定する
    * @return {JSON}
    */
	function extendRequestJson(a, b, overwrite){
		if(a && b){
			for(var key in b){
				if(!overwrite && util.isEmpty(b[key])) continue;
				if(!overwrite && typeof b[key] == "object" && (util.isEmpty(b[key]) || !b[key][0])) {
					//配列要素が存在しない場合、設定しない
					continue;
				}
				a[key] = b[key];
			}
			return a;
		}
		return {};
	}
	/**
	* GETメソッド向けリクエストパラメータを調整
	* 要素のない配列、改行文字を含む文字列を除去
    * @method requestDataParse
	* @param a {JSON}
    * @return {JSON} adjust a
    */
	function requestDataParse(a){
		var _ret = {};
		for(var key in a){
			if(typeof a[key] == "object" && (util.isEmpty(a[key]) || !a[key][0])) {
				//配列要素が存在しない場合、設定しない
				continue;
			}
			if(typeof a[key] == "string" && a[key].indexOf("\n")>=0){
				//改行文字含む文字列は含めない
				continue;
			}
			if(typeof a[key] == "string" && util.isNumeric(a[key]) && a[key]==(a[key])|0+""){
				a[key] = a[key]|0;
			}
			_ret[key] = a[key];
		}
		return _ret;
	}
	/**
	* セッションタイムアウトエラーを表示し、ログアウトする
    * @private
    * @method errorMessage
	* @param msg {String}
    * @return {void} return nothing
    */
	function errorMessage(msg){
		dom.errorMessage(msg, _logout);
	}
	/**
	* メッセージコード、パラメータより、メッセージを表示
    * @method alertMessage
	* @param messageCode {String}
	* @param messageParam {String}
	* @param callback {Function}
    * @return {void} return nothing
    */
	function alertMessage(messageCode, messageParam, callback){
		var message = getMessage(messageCode, messageParam);
		if(_isDebug) message["body"] = message["body"]+"<br>"+messageParam;
		if(util.isEmpty(message["title"])) message["title"] = messageCode;
		if(util.isEmpty(message["body"])) message["body"] = messageParam;
		dom.alertMessage(message["title"], message["body"], callback);
	}
	/**
	* メッセージコード、パラメータより、確認メッセージを表示
    * @private
	* @method alertMconfirmMessageessage
	* @param messageCode {String}
	* @param messageParam {String}
	* @param callback {Function}
    * @return {void} return nothing
    */
	function confirmMessage(messageCode, messageParam, callback){
		var message = getMessage(messageCode, messageParam);
		dom.confirmMessage(message["title"], message["body"], callback);
	}

	function loadRequestCache(){
		_requestCache = util.getLocalData("_requestCache");
		if(_requestCache===null) _requestCache={};
		for(var key in _requestCache){
			getRequestCache(key);
		}
	}
	function getRequestCache(key){
		if(!_requestCache[key]) return null;
		if(!_requestCache[key]["time"] || !_requestCache[key]["result"]) {
			delete _requestCache[key];
			return null;
		}
		var now = +new Date();
		if(now-_requestCache[key]["time"] > _cache["userSetting"]["requestCacheTime"]) {
			delete _requestCache[key];
			return null;
		}
		return _requestCache[key]["result"];
	}
	function setRequestCache(key, data){
		var now = +new Date();
		//_requestCache[key] = {"key" : key , "time":now, "result" : data, "request" : request};
		_requestCache[key] = {"time":now, "result" : data};
		util.setLocalData("_requestCache", _requestCache);
	}
	function clearRequestCache(){
		util.setLocalData("_requestCache" , "");
		_requestCache = {};
	}
	startProc();
	root.service = $.extend({}, root.service, public_method);

})(this);
