<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{URL::to('assets/js/backend-bundle.min.js')}}"></script>
<script src="{{URL::to('assets/js/flex-tree.min.js')}}"></script>
<script src="{{URL::to('/assets/js/tree.js')}}"></script>
<script src="{{URL::to('/assets/js/table-treeview.js')}}"></script>
<script src="{{URL::to('/assets/js/masonry.pkgd.min.js')}}"></script>
<script src="{{URL::to('/assets/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{URL::to('/assets/js/mapbox-gl.js')}}"></script>
<script src="{{URL::to('/assets/js/mapbox.js')}}"></script>
<script src="{{URL::to('/assets/vendor/fullcalendar/core/main.js')}}"></script>
<script src="{{URL::to('/assets/vendor/fullcalendar/daygrid/main.js')}}"></script>
<script src="{{URL::to('/assets/vendor/fullcalendar/timegrid/main.js')}}"></script>
<script src="{{URL::to('/assets/vendor/fullcalendar/list/main.js')}}"></script>
<script src="{{URL::to('/assets/js/sweetalert.js')}}"></script>
<script src="{{URL::to('/assets/js/vector-map-custom.js')}}"></script>
<script src="{{URL::to('/assets/js/customizer.js')}}"></script>
<script src="{{URL::to('/assets/js/rtl.js')}}"></script>
<script src="{{URL::to('/assets/js/chart-custom.js')}}"></script>
<script src="{{URL::to('/assets/js/slider.js')}}"></script>
<script src="{{URL::to('/assets/js/app.js')}}"></script>
<script>
        $('select').select2({
            minimumResultsForSearch: 3
        });
        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                     toastr.info("{{ Session::get('message') }}");
                     break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
<script language="javascript">
function getkey(e)
{
if (window.event)
   return window.event.keyCode;
else if (e)
   return e.which;
else
   return null;
}
function goodchars(e, goods, field)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
 
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
 
// check goodkeys
if (goods.indexOf(keychar) != -1)
    return true;
// control keys
if ( key==null || key==0 || key==8 || key==9 || key==27 )
   return true;
    
if (key == 13) {
    var i;
    for (i = 0; i < field.form.elements.length; i++)
        if (field == field.form.elements[i])
            break;
    i = (i + 1) % field.form.elements.length;
    field.form.elements[i].focus();
    return false;
    };
// else return false
return false;
}
</script>