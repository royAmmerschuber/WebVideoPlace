function loadList(){
    $.ajax({
        url:"/WebVideoPlace/Main/loadList",
        type:"POST",
        data:{
            "search":$("#search").val()
        },
        success:function (result) {
            var html="";
            JSON.parse(result).forEach( function (vid) {
                html+=generateElement(vid);
            });
            $("#list").html(html);
        }
    });
}
function generateElement(vid){
    var html;

    html=
        "<div class=\"col-md-4\" >" +
        "<div class=\"card mb-4 box-shadow\">\n" +
        "    <img class=\"card-img-top\"\n" +
        "        data-src=\"holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail\"\n" +
        "        alt=\"Thumbnail [100%x225]\" style=\"height: 225px; width: 100%; display: block;\"\n" +
        "        src=\"/WebVideoPlace/media/thumbnail/"+vid.thumbnail+"\"\n" +
        "        data-holder-rendered=\"true\">\n" +
        "    <div class=\"card-body\">\n" +
        "        <h1>"+vid.name+"</h1>" +
        "        <p class=\"card-text\">"+vid.description+"</p>\n" +
        "        <div class=\"d-flex justify-content-between align-items-center\">\n" +
        "            <div class=\"btn-group\">\n" +
        "                <button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" onclick='view("+vid.id+")'>View</button>\n" +
        (vid.isMine==true?"    <button type=\"button\" class=\"btn btn-sm btn-outline-secondary\" onclick='edit("+vid.id+")'>Edit</button>\n":"")+
        "            </div>\n" +
        "            <small class=\"text-muted\">"+vid.score+"</small>\n" +
        "        </div>\n" +
        "    </div>\n" +
        "</div>" +
        "</div>";
    return html;
}
function view(id) {
    window.location.href="/WebVideoPlace/Video?id="+id;
}
function edit(id) {
    window.location.href="/WebVideoPlace/Video/edit?id="+id;

}
