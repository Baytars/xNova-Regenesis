import core.Registry;

class Bootstrap {
    
    public static function init() {
        var url = Registry.set("site_url", "http://xnovaes.test");
        
        var config = Registry.set("config", {
            web : {
                path : {
                    map : url + "/map/get/id/1"
                }
            },
            locale : "ru"
        });
    }
}
