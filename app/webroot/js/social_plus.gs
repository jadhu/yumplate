var API = {
UPDATE_WITH_MEDIA : "https://api.twitter.com/1.1/statuses/update_with_media.json"
};
 
function oAuthConfig() {
var oAuthConfig = UrlFetchApp.addOAuthService("twitter");
 
oAuthConfig.setAccessTokenUrl("https://api.twitter.com/oauth/access_token");
oAuthConfig.setRequestTokenUrl("https://api.twitter.com/oauth/request_token");
oAuthConfig.setAuthorizationUrl("https://api.twitter.com/oauth/authorize");
 
oAuthConfig.setConsumerKey(ScriptProperties.getProperty("wFSwIc9Mx5XJjDbAJN7iNHmGo"));
oAuthConfig.setConsumerSecret(ScriptProperties.getProperty("0XcpY5qXZyOy6MU7AQ34Cj72aYVdp9uV2cg4tunbl6GqrUzMtQ"));
}
 
function postImage(tweetText, imageUrl) {
oAuthConfig();
 
var boundary = "cuthere",
status = tweetText,
picture = UrlFetchApp.fetch(imageUrl).getBlob().setContentTypeFromExtension(),
requestBody, options, request;
 
requestBody = Utilities.newBlob("--" + boundary + "\r\n" +
"Content-Disposition: form-data; name=\"status\"\r\n\r\n" + status + "\r\n" +
"--" + boundary + "\r\n" +
"Content-Disposition: form-data; name=\"media[]\"; filename=\"" + picture.getName() + "\"\r\n" +
"Content-Type: " + picture.getContentType() + "\r\n\r\n"
).getBytes();
 
requestBody = requestBody.concat(picture.getBytes());
requestBody = requestBody.concat(Utilities.newBlob("\r\n--" + boundary + "--\r\n").getBytes());
 
options = {
oAuthServiceName : "twitter",
oAuthUseToken : "always",
method : "POST",
contentType : "multipart/form-data; boundary=" + boundary,
payload : requestBody
};
 
return UrlFetchApp.fetch(API.UPDATE_WITH_MEDIA, options);
} 

$(document).ready(function(){
  $('.tw-share').click(function() {
     
      var price='$ '+$('#productprice').text();
      var name=$('.product_name').html();
      var story=$('#product_story').val()+' <br/><p> Price:</p>'+price;

      var imageUrl='http://beta.yumplate.com/images/original/'+$('#image_name').val();

      var tweetText = name +'<br/>' +story;


      postImage(tweetText, imageUrl); 
      
    });

  
});