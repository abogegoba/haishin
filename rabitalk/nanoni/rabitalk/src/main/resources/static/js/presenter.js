/*
 * (C) Copyright 2014 Kurento (http://kurento.org/)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

var ws = new WebSocket('wss://' + location.host + '/call');
var video;
var webRtcPeer;
var room;
var count=1;
var timer;
var input_message;
var flag=1;;
var flag2=1;
var presen = 0;

var log = function(){
        var console = new Console();
	var message = {
		id : 'checkroom',
		room : room
	};
	sendMessage(message);
};


window.onload = function() {
	video = document.getElementById('video');
	disableStopButton();
}

window.onbeforeunload = function() {
getJSONOff(check+"/offline/"+room);
	ws.close();
}

ws.onmessage = function(message) {
	var console = new Console();
	var parsedMessage = JSON.parse(message.data);
	//console.info('Received message: ' + message.data);


//		console.log(parsedMessage.id);
//		console.log(parsedMessage.response);

	switch (parsedMessage.id) {
	case 'checkroom':
clearTimeout(timer);
		break;
	case 'presenterResponse':
		presenterResponse(parsedMessage);
		break;
	case 'viewerResponse':
		viewerResponse(parsedMessage);
		break;
	case 'iceCandidate':
		webRtcPeer.addIceCandidate(parsedMessage.candidate, function(error) {
			if (error)
				return ;//console.error('Error adding candidate: ' + error);
		});
		break;
	case 'stopCommunication':
		dispose();
		break;
	case 'urlResponse':
	/*	console.log('room:'+parsedMessage.room);
		console.log('img:'+parsedMessage.img);
		console.log('url:'+parsedMessage.response);	*/
		var h = '<div style="z-index:100;position:absolute;top:0px;left:300px"> <a href="'+parsedMessage.response+'" target="item"> <img src="'+parsedMessage.img+'" style="width:64px;height:64px"></a></div>';
		document.getElementById('items').innerHTML = h ;
		var h2 = '<div style="z-index:200;position:absolute;top:64px;left:300px"> <a href="'+parsedMessage.response+'" target="item"> <img src="https://jvideo.club/html/upload/save_image/buynow.png" style="width:64px;height:64px"></a></div>';
		document.getElementById('buynow').innerHTML = h2 ;
		break;
	case 'count':
	/*	console.log('room:'+parsedMessage.room);
		console.log('img:'+parsedMessage.img);
		console.log('url:'+parsedMessage.response);*/
		var h = '<div style="z-index:100;position:absolute;top:40px;left:0pxi;background-color: #ffffff; color: #000000;font-size:20px"><b>'+parsedMessage.response+'/'+parsedMessage.nobe+'</b></div>';
		document.getElementById('count').innerHTML = h ;
		break;
	default:
		//console.error('Unrecognized message', parsedMessage);
	}
}

function presenterResponse(message) {
	if (message.response != 'accepted') {
		var errorMsg = message.message ? message.message : 'Unknow error';
		//console.info('Call not accepted for the following reason: ' + errorMsg);
		dispose();
getJSONOff(check+"/offline/"+room);
	} else {
		webRtcPeer.processAnswer(message.sdpAnswer, function(error) {
			if (error)
				return ;//console.error(error);
		});
	}
}

function viewerResponse(message) {
	if (message.response != 'accepted') {
		var errorMsg = message.message ? message.message : 'Unknow error';
		//console.info('Call not accepted for the following reason: ' + errorMsg);
		dispose();
	} else {
		webRtcPeer.processAnswer(message.sdpAnswer, function(error) {
			if (error)
				return ;//console.error(error);
		});
	}
}


function url() {
        //console.log("push URL");
        if(count==0){
                var message = {
                        id : 'url',
                        room : input_message,
                        img : 'https://jvideo.club/html/upload/save_image/0513064721_5ebb196925166.jpg',
                        url : 'https://jvideo.club/products/detail/3'
                };
                count=1;
        } else {
                var message = {
                        id : 'url',
                        room : input_message,
                        img : 'https://jvideo.club/html/upload/save_image/0513064721_5ebb196925166.jpg',
                        url : 'https://jvideo.club/products/detail/3'
                };
                count=0;
        }
        sendMessage(message);
}

function presenter() {
	if (!webRtcPeer) {
		showSpinner(video);

		var options = {
			localVideo : video,
			onicecandidate : onIceCandidate
		}
		webRtcPeer = new kurentoUtils.WebRtcPeer.WebRtcPeerSendonly(options,
				function(error) {
					if (error) {
						return ;//console.error(error);
					}
					webRtcPeer.generateOffer(onOfferPresenter);
				});
getJSON(check+"/online/"+room);
		presen = 1;
		enableStopButton();
	input_message = document.getElementById("input_message").value;
	}
}

function onOfferPresenter(error, offerSdp) {
	if (error)
		return ;//console.error('Error generating the offer');
	;//console.info('Invoking SDP offer callback function ' + location.host);
	var input_message = document.getElementById("input_message").value;
	var message = {
		id : 'room',
		room : input_message
	}
	sendMessage(message);
	var message = {
		id : 'presenter',
		sdpOffer : offerSdp
	}
	sendMessage(message);
}

function viewer() {
        if (!webRtcPeer) {
                showSpinner(video);

                var options = {
                        remoteVideo : video,
                        onicecandidate : onIceCandidate
                }
                webRtcPeer = new kurentoUtils.WebRtcPeer.WebRtcPeerRecvonly(options,
                                function(error) {
                                        if (error) {
                                                return ;//console.error(error);
                                        }
                                        this.generateOffer(onOfferViewer);
                                });
                enableStopButton();
if(flag2==1) document.getElementById("stop").click();
	}
}

function viewer2() {
	if (!webRtcPeer) {
		showSpinner(video);

		var options = {
			remoteVideo : video,
			onicecandidate : onIceCandidate
		}
		webRtcPeer = new kurentoUtils.WebRtcPeer.WebRtcPeerRecvonly(options,
				function(error) {
					if (error) {
						return ;//console.error(error);
					}
					this.generateOffer(onOfferViewer);
					if(flag==1){
						dispose();
						webRtcPeer = null;
                                        }

				});
//document.getElementById("stop").click();
                enableStopButton();
	}
}
function sleep(waitMsec) {
  var startMsec = new Date();
 
  // 指定ミリ秒間だけループさせる（CPUは常にビジー状態）
  while (new Date() - startMsec < waitMsec);
}

function onOfferViewer(error, offerSdp) {
	if (error)
		return ;//console.error('Error generating the offer');
	;//console.info('Invoking SDP offer callback function ' + location.host);
	var input_message = document.getElementById("input_message").value;
	var message = {
		id : 'room',
		room : input_message
	}
	sendMessage(message);
	var message = {
		id : 'viewer',
		sdpOffer : offerSdp
	}
	sendMessage(message);
}

function onIceCandidate(candidate) {
	;//console.log("Local candidate" + JSON.stringify(candidate));

	var message = {
		id : 'onIceCandidate',
		candidate : candidate
	};
	sendMessage(message);
}

function stop() {
        var console = new Console();
        var message = {
                id : 'stop'
        }
        sendMessage(message);
        dispose();
if(flag2==1){
	flag2=0;
	document.getElementById("viewer").click();
}
}

function dispose() {
        var console = new Console();
getJSONOff(check+"/offline/"+room);
	if (webRtcPeer) {
		webRtcPeer.dispose();
		webRtcPeer = null;
	}
	hideSpinner(video);

	disableStopButton();
	if(flag2==0){
		/*location.href = 'https://jvideo.club';*/

document.location.assign('https://jvideo.club');
MyWebkitNamespace.messageHandlers.url.postMessage("url");
	}
}

function disableStopButton() {
	enableButton('#presenter', 'presenter()');
	enableButton('#viewer', 'viewer()');
	enableButton('#url', 'url()');
	disableButton('#stop');
}

function enableStopButton() {
	disableButton('#presenter');
	disableButton('#viewer');
	enableButton('#url', 'url()');
	enableButton('#stop', 'stop()');
}

function disableButton(id) {
	$(id).attr('disabled', true);
	$(id).removeAttr('onclick');
}

function enableButton(id, functionName) {
	$(id).attr('disabled', false);
	$(id).attr('onclick', functionName);
}

function sendMessage(message) {
	var jsonMessage = JSON.stringify(message);
	ws.send(jsonMessage);
}

function showSpinner() {
	for (var i = 0; i < arguments.length; i++) {
		arguments[i].poster = './img/transparent-1px.png';
		arguments[i].style.background = 'center transparent url("./img/spinner.gif") no-repeat';
	}
}

function hideSpinner() {
	for (var i = 0; i < arguments.length; i++) {
		arguments[i].src = '';
		arguments[i].poster = './img/webrtc.png';
		arguments[i].style.background = '';
	}
}

/**
 * Lightbox utility (to display media pipeline image in a modal dialog)
 */
$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});

function checkroom(roomno){
        var message = {
                id : 'checkroom',
                room : roomno
        }
        sendMessage(message);
}

function getJSON(url) {
        var iframeOBJ = document.getElementById('target_element').contentWindow;
        var dm = new Array(2);

        dm[0] = "online"+room;
        dm[1] = url;
        iframeOBJ.postMessage(dm, 'https://live.jvideo.club/presen');
}

function getJSONOff(url) {
        var iframeOBJ = document.getElementById('target_element').contentWindow;
        var dm = new Array(2);

        dm[0] = "offline"+room;
        dm[1] = url;
        iframeOBJ.postMessage(dm, 'https://live.jvideo.club/presen');
}
