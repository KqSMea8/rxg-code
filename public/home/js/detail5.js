/*!
 * artTemplate - Template Engine
 * https://github.com/aui/artTemplate
 * Released under the MIT, BSD, and GPL Licenses
 */

!(function () {


    /**
     * 妯℃澘寮曟搸
     * @name    template
     * @param   {String}            妯℃澘鍚�
     * @param   {Object, String}    鏁版嵁銆傚鏋滀负瀛楃涓插垯缂栬瘧骞剁紦瀛樼紪璇戠粨鏋�
     * @return  {String, Function}  娓叉煋濂界殑HTML瀛楃涓叉垨鑰呮覆鏌撴柟娉�
     */
    var template = function (filename, content) {
        return typeof content === 'string'
            ?   compile(content, {
                filename: filename
            })
            :   renderFile(filename, content);
    };


    template.version = '3.0.0';


    /**
     * 璁剧疆鍏ㄥ眬閰嶇疆
     * @name    template.config
     * @param   {String}    鍚嶇О
     * @param   {Any}       鍊�
     */
    template.config = function (name, value) {
        defaults[name] = value;
    };



    var defaults = template.defaults = {
        openTag: '<%',    // 閫昏緫璇硶寮€濮嬫爣绛�
        closeTag: '%>',   // 閫昏緫璇硶缁撴潫鏍囩
        escape: true,     // 鏄惁缂栫爜杈撳嚭鍙橀噺鐨� HTML 瀛楃
        cache: true,      // 鏄惁寮€鍚紦瀛橈紙渚濊禆 options 鐨� filename 瀛楁锛�
        compress: false,  // 鏄惁鍘嬬缉杈撳嚭
        parser: null      // 鑷畾涔夎娉曟牸寮忓櫒 @see: template-syntax.js
    };


    var cacheStore = template.cache = {};


    /**
     * 娓叉煋妯℃澘
     * @name    template.render
     * @param   {String}    妯℃澘
     * @param   {Object}    鏁版嵁
     * @return  {String}    娓叉煋濂界殑瀛楃涓�
     */
    template.render = function (source, options) {
        //iWebShop鑷畾涔夋敼鍐欙紝鍏煎2.0鐗堟湰
        options = options ? options : {};
        return renderFile(source, options);
        //return compile(source, options);
    };


    /**
     * 娓叉煋妯℃澘(鏍规嵁妯℃澘鍚�)
     * @name    template.render
     * @param   {String}    妯℃澘鍚�
     * @param   {Object}    鏁版嵁
     * @return  {String}    娓叉煋濂界殑瀛楃涓�
     */
    var renderFile = template.renderFile = function (filename, data) {
        var fn = template.get(filename) || showDebugInfo({
            filename: filename,
            name: 'Render Error',
            message: 'Template not found'
        });
        return data ? fn(data) : fn;
    };


    /**
     * 鑾峰彇缂栬瘧缂撳瓨锛堝彲鐢卞閮ㄩ噸鍐欐鏂规硶锛�
     * @param   {String}    妯℃澘鍚�
     * @param   {Function}  缂栬瘧濂界殑鍑芥暟
     */
    template.get = function (filename) {

        var cache;

        if (cacheStore[filename]) {
            // 浣跨敤鍐呭瓨缂撳瓨
            cache = cacheStore[filename];
        } else if (typeof document === 'object') {
            // 鍔犺浇妯℃澘骞剁紪璇�
            var elem = document.getElementById(filename);

            if (elem) {
                var source = (elem.value || elem.innerHTML)
                    .replace(/^\s*|\s*$/g, '');
                cache = compile(source, {
                    filename: filename
                });
            }
        }

        return cache;
    };


    var toString = function (value, type) {

        if (typeof value !== 'string') {

            type = typeof value;
            if (type === 'number') {
                value += '';
            } else if (type === 'function') {
                value = toString(value.call(value));
            } else {
                value = '';
            }
        }

        return value;

    };


    var escapeMap = {
        "<": "&#60;",
        ">": "&#62;",
        '"': "&#34;",
        "'": "&#39;",
        "&": "&#38;"
    };


    var escapeFn = function (s) {
        return escapeMap[s];
    };

    var escapeHTML = function (content) {
        return toString(content)
            .replace(/&(?![\w#]+;)|[<>"']/g, escapeFn);
    };


    var isArray = Array.isArray || function (obj) {
        return ({}).toString.call(obj) === '[object Array]';
    };


    var each = function (data, callback) {
        var i, len;
        if (isArray(data)) {
            for (i = 0, len = data.length; i < len; i++) {
                callback.call(data, data[i], i, data);
            }
        } else {
            for (i in data) {
                callback.call(data, data[i], i);
            }
        }
    };


    var utils = template.utils = {

        $helpers: {},

        $include: renderFile,

        $string: toString,

        $escape: escapeHTML,

        $each: each

    };/**
     * 娣诲姞妯℃澘杈呭姪鏂规硶
     * @name    template.helper
     * @param   {String}    鍚嶇О
     * @param   {Function}  鏂规硶
     */
    template.helper = function (name, helper) {
        helpers[name] = helper;
    };

    var helpers = template.helpers = utils.$helpers;




    /**
     * 妯℃澘閿欒浜嬩欢锛堝彲鐢卞閮ㄩ噸鍐欐鏂规硶锛�
     * @name    template.onerror
     * @event
     */
    template.onerror = function (e) {
        var message = 'Template Error\n\n';
        for (var name in e) {
            message += '<' + name + '>\n' + e[name] + '\n\n';
        }

        if (typeof console === 'object') {
            console.error(message);
        }
    };


// 妯℃澘璋冭瘯鍣�
    var showDebugInfo = function (e) {

        template.onerror(e);

        return function () {
            return '{Template Error}';
        };
    };


    /**
     * 缂栬瘧妯℃澘
     * 2012-6-6 @TooBug: define 鏂规硶鍚嶆敼涓� compile锛屼笌 Node Express 淇濇寔涓€鑷�
     * @name    template.compile
     * @param   {String}    妯℃澘瀛楃涓�
     * @param   {Object}    缂栬瘧閫夐」
     *
     *      - openTag       {String}
     *      - closeTag      {String}
     *      - filename      {String}
     *      - escape        {Boolean}
     *      - compress      {Boolean}
     *      - debug         {Boolean}
     *      - cache         {Boolean}
     *      - parser        {Function}
     *
     * @return  {Function}  娓叉煋鏂规硶
     */
    var compile = template.compile = function (source, options) {

        // 鍚堝苟榛樿閰嶇疆
        options = options || {};
        for (var name in defaults) {
            if (options[name] === undefined) {
                options[name] = defaults[name];
            }
        }


        var filename = options.filename;


        try {

            var Render = compiler(source, options);

        } catch (e) {

            e.filename = filename || 'anonymous';
            e.name = 'Syntax Error';

            return showDebugInfo(e);

        }


        // 瀵圭紪璇戠粨鏋滆繘琛屼竴娆″寘瑁�

        function render (data) {

            try {

                return new Render(data, filename) + '';

            } catch (e) {

                // 杩愯鏃跺嚭閿欏悗鑷姩寮€鍚皟璇曟ā寮忛噸鏂扮紪璇�
                if (!options.debug) {
                    options.debug = true;
                    return compile(source, options)(data);
                }

                return showDebugInfo(e)();

            }

        }


        render.prototype = Render.prototype;
        render.toString = function () {
            return Render.toString();
        };


        if (filename && options.cache) {
            cacheStore[filename] = render;
        }


        return render;

    };




// 鏁扮粍杩唬
    var forEach = utils.$each;


// 闈欐€佸垎鏋愭ā鏉垮彉閲�
    var KEYWORDS =
        // 鍏抽敭瀛�
        'break,case,catch,continue,debugger,default,delete,do,else,false'
        + ',finally,for,function,if,in,instanceof,new,null,return,switch,this'
        + ',throw,true,try,typeof,var,void,while,with'

        // 淇濈暀瀛�
        + ',abstract,boolean,byte,char,class,const,double,enum,export,extends'
        + ',final,float,goto,implements,import,int,interface,long,native'
        + ',package,private,protected,public,short,static,super,synchronized'
        + ',throws,transient,volatile'

        // ECMA 5 - use strict
        + ',arguments,let,yield'

        + ',undefined';

    var REMOVE_RE = /\/\*[\w\W]*?\*\/|\/\/[^\n]*\n|\/\/[^\n]*$|"(?:[^"\\]|\\[\w\W])*"|'(?:[^'\\]|\\[\w\W])*'|\s*\.\s*[$\w\.]+/g;
    var SPLIT_RE = /[^\w$]+/g;
    var KEYWORDS_RE = new RegExp(["\\b" + KEYWORDS.replace(/,/g, '\\b|\\b') + "\\b"].join('|'), 'g');
    var NUMBER_RE = /^\d[^,]*|,\d[^,]*/g;
    var BOUNDARY_RE = /^,+|,+$/g;


// 鑾峰彇鍙橀噺
    function getVariable (code) {
        return code
            .replace(REMOVE_RE, '')
            .replace(SPLIT_RE, ',')
            .replace(KEYWORDS_RE, '')
            .replace(NUMBER_RE, '')
            .replace(BOUNDARY_RE, '')
            .split(/^$|,+/);
    };


// 瀛楃涓茶浆涔�
    function stringify (code) {
        return "'" + code
        // 鍗曞紩鍙蜂笌鍙嶆枩鏉犺浆涔�
            .replace(/('|\\)/g, '\\$1')
            // 鎹㈣绗﹁浆涔�(windows + linux)
            .replace(/\r/g, '\\r')
            .replace(/\n/g, '\\n') + "'";
    }


    function compiler (source, options) {

        var debug = options.debug;
        var openTag = options.openTag;
        var closeTag = options.closeTag;
        var parser = options.parser;
        var compress = options.compress;
        var escape = options.escape;



        var line = 1;
        var uniq = {$data:1,$filename:1,$utils:1,$helpers:1,$out:1,$line:1};



        var isNewEngine = ''.trim;// '__proto__' in {}
        var replaces = isNewEngine
            ? ["$out='';", "$out+=", ";", "$out"]
            : ["$out=[];", "$out.push(", ");", "$out.join('')"];

        var concat = isNewEngine
            ? "$out+=text;return $out;"
            : "$out.push(text);";

        var print = "function(){"
            +      "var text=''.concat.apply('',arguments);"
            +       concat
            +  "}";

        var include = "function(filename,data){"
            +      "data=data||$data;"
            +      "var text=$utils.$include(filename,data,$filename);"
            +       concat
            +   "}";

        var headerCode = "'use strict';"
            + "var $utils=this,$helpers=$utils.$helpers,"
            + (debug ? "$line=0," : "");

        var mainCode = replaces[0];

        var footerCode = "return new String(" + replaces[3] + ");"

        // html涓庨€昏緫璇硶鍒嗙
        forEach(source.split(openTag), function (code) {
            code = code.split(closeTag);

            var $0 = code[0];
            var $1 = code[1];

            // code: [html]
            if (code.length === 1) {

                mainCode += html($0);

                // code: [logic, html]
            } else {

                mainCode += logic($0);

                if ($1) {
                    mainCode += html($1);
                }
            }


        });

        var code = headerCode + mainCode + footerCode;

        // 璋冭瘯璇彞
        if (debug) {
            code = "try{" + code + "}catch(e){"
                +       "throw {"
                +           "filename:$filename,"
                +           "name:'Render Error',"
                +           "message:e.message,"
                +           "line:$line,"
                +           "source:" + stringify(source)
                +           ".split(/\\n/)[$line-1].replace(/^\\s+/,'')"
                +       "};"
                + "}";
        }



        try {


            var Render = new Function("$data", "$filename", code);
            Render.prototype = utils;

            return Render;

        } catch (e) {
            e.temp = "function anonymous($data,$filename) {" + code + "}";
            throw e;
        }




        // 澶勭悊 HTML 璇彞
        function html (code) {

            // 璁板綍琛屽彿
            line += code.split(/\n/).length - 1;

            // 鍘嬬缉澶氫綑绌虹櫧涓庢敞閲�
            if (compress) {
                code = code
                    .replace(/\s+/g, ' ')
                    .replace(/<!--.*?-->/g, '');
            }

            if (code) {
                code = replaces[1] + stringify(code) + replaces[2] + "\n";
            }

            return code;
        }


        // 澶勭悊閫昏緫璇彞
        function logic (code) {

            var thisLine = line;

            if (parser) {

                // 璇硶杞崲鎻掍欢閽╁瓙
                code = parser(code, options);

            } else if (debug) {

                // 璁板綍琛屽彿
                code = code.replace(/\n/g, function () {
                    line ++;
                    return "$line=" + line +  ";";
                });

            }


            // 杈撳嚭璇彞. 缂栫爜: <%=value%> 涓嶇紪鐮�:<%=#value%>
            // <%=#value%> 绛夊悓 v2.0.3 涔嬪墠鐨� <%==value%>
            if (code.indexOf('=') === 0) {

                var escapeSyntax = escape && !/^=[=#]/.test(code);

                code = code.replace(/^=[=#]?|[\s;]*$/g, '');

                // 瀵瑰唴瀹圭紪鐮�
                if (escapeSyntax) {

                    var name = code.replace(/\s*\([^\)]+\)/, '');

                    // 鎺掗櫎 utils.* | include | print

                    if (!utils[name] && !/^(include|print)$/.test(name)) {
                        code = "$escape(" + code + ")";
                    }

                    // 涓嶇紪鐮�
                } else {
                    code = "$string(" + code + ")";
                }


                code = replaces[1] + code + replaces[2];

            }

            if (debug) {
                code = "$line=" + thisLine + ";" + code;
            }

            // 鎻愬彇妯℃澘涓殑鍙橀噺鍚�
            forEach(getVariable(code), function (name) {

                // name 鍊煎彲鑳戒负绌猴紝鍦ㄥ畨鍗撲綆鐗堟湰娴忚鍣ㄤ笅
                if (!name || uniq[name]) {
                    return;
                }

                var value;

                // 澹版槑妯℃澘鍙橀噺
                // 璧嬪€间紭鍏堢骇:
                // [include, print] > utils > helpers > data
                if (name === 'print') {

                    value = print;

                } else if (name === 'include') {

                    value = include;

                } else if (utils[name]) {

                    value = "$utils." + name;

                } else if (helpers[name]) {

                    value = "$helpers." + name;

                } else {

                    value = "$data." + name;
                }

                headerCode += name + "=" + value + ",";
                uniq[name] = true;


            });

            return code + "\n";
        }


    };




// RequireJS && SeaJS
    if (typeof define === 'function') {
        define(function() {
            return template;
        });

// NodeJS
    } else if (typeof exports !== 'undefined') {
        module.exports = template;
    } else {
        this.template = template;
    }

})();