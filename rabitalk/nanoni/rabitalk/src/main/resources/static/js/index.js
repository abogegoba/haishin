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
var videoInput;
var videoOutput;
var webRtcPeer;
var response;
var callerMessage;
var from;

var registerName = null;
var registerState = null;
const NOT_REGISTERED = 0;
const REGISTERING = 1;
const REGISTERED = 2;

function setRegisterState(nextState) {
	switch (nextState) {
	case NOT_REGISTERED:
		enableButton('#register', 'register()');
		setCallState(NO_CALL);
		break;
	case REGISTERING:
		disableButton('#register');
		break;
	case REGISTERED:
		disableButton('#register');
		setCallState(NO_CALL);
		break;
	default:
		return;
	}
	registerState = nextState;
}

var callState = null;
const NO_CALL = 0;
const PROCESSING_CALL = 1;
const IN_CALL = 2;

function setCallState(nextState) {
	switch (nextState) {
	case NO_CALL:
		enableButton('#call', 'call()');
		//disableButton('#terminate');
                enableButton('#terminate', 'stop()');
		disableButton('#play');
		break;
	case PROCESSING_CALL:
		disableButton('#call');
                enableButton('#terminate', 'stop()');
		disableButton('#play');
		break;
	case IN_CALL:
		disableButton('#call');
		enableButton('#terminate', 'stop()');
		disableButton('#play');
		break;
	default:
		return;
	}
	callState = nextState;
}

/*
window.onpageshow = function(){
	document.location.reload();
}
*/
window.onload = function() {
	console = new Console();
	setRegisterState(NOT_REGISTERED);
	var drag = new Draggabilly(document.getElementById('videoSmall'));
	videoInput = document.getElementById('videoInput');
	videoOutput = document.getElementById('videoOutput');
	/*document.getElementById('name').focus();*/
}

window.onbeforeunload = function() {
	ws.close();
}

ws.onmessage = function(message) {
	var parsedMessage = JSON.parse(message.data);


        console = new Console();
	//console.log(parsedMessage.id);


	switch (parsedMessage.id) {
	case 'registerResponse':
		registerResponse(parsedMessage);
		break;
	case 'callResponse':
		callResponse(parsedMessage);
		break;
	case 'incomingCall':
	var timer = setInterval(incomtimer, 1000);
		incomingCall(parsedMessage);
		break;
	case 'startCommunication':
		startCommunication(parsedMessage);
		break;
	case 'stopCommunication':
		stop(true);
		break;
	case 'userlist':
		userlist(parsedMessage);
		break;
	case 'iceCandidate':
		webRtcPeer.addIceCandidate(parsedMessage.candidate, function(error) {
			if (error)
				return console.error('Error adding candidate: ' + error);
		});
		break;
	default:
		console.error('Unrecognized message', parsedMessage);
	}
}

function registerResponse(message) {
	if (message.response == 'accepted') {
		setRegisterState(REGISTERED);
	} else {
		setRegisterState(NOT_REGISTERED);
		var errorMessage = message.message ? message.message
				: 'Unknown reason for register rejection.';
		alert('そのユーザー名は使われています。');
	}
}

function callResponse(message) {
	if (message.response != 'accepted') {
		var errorMessage = message.message ? message.message
				: 'Unknown reason for call rejection.';
		if(registerState==0){
                	alert('オンラインになってません。オンラインにしてください。');
			stop2();
		} else {
                	alert('相手がオンラインになってません。オンラインにしてもらってください。');
			stop2();
		}
	} else {
		setCallState(IN_CALL);
		webRtcPeer.processAnswer(message.sdpAnswer, function(error) {
			if (error)
				return console.error(error);
		});
	}
}

function startCommunication(message) {
	setCallState(IN_CALL);
	webRtcPeer.processAnswer(message.sdpAnswer, function(error) {
		if (error)
			return console.error(error);
	});
}

var incomtimer = function(){
                var response = {
                        id : 'incomingCallResponse',
                        from : message.from,
                        callResponse : 'reject',
                        message : 'user declined'
                };
                sendMessage(response);
                stop();
}

function incomingCall(message) {
	// If bussy just reject without disturbing user
	if (callState != NO_CALL) {
		var response = {
			id : 'incomingCallResponse',
			from : message.from,
			callResponse : 'reject',
			message : 'bussy'
		};
		return sendMessage(response);
	}
	setCallState(PROCESSING_CALL);
	if (confirm('User ' + message.from
			+ ' から呼び出しです。でますか?')) {
		showSpinner(videoInput, videoOutput);

		from = message.from;
		var options = {
			localVideo : videoInput,
			remoteVideo : videoOutput,
			onicecandidate : onIceCandidate,
			onerror : onError
		}
		webRtcPeer = new kurentoUtils.WebRtcPeer.WebRtcPeerSendrecv(options,
				function(error) {
					if (error) {
						return console.error(error);
					}
					webRtcPeer.generateOffer(onOfferIncomingCall);
				});
	} else {
		var response = {
			id : 'incomingCallResponse',
			from : message.from,
			callResponse : 'reject',
			message : 'user declined'
		};
		sendMessage(response);
		stop();
	}
}

function onOfferIncomingCall(error, offerSdp) {
	if (error)
		return console.error("Error generating the offer");
	var response = {
		id : 'incomingCallResponse',
		from : from,
		callResponse : 'accept',
		sdpOffer : offerSdp
	};
	sendMessage(response);
}

function register() {
	var name = document.getElementById('name').value;
	if (name == '') {
		window.alert('ニックネームを登録してくださ');
		location.href = 'https://live.jvideo.club/editnickname'
		return;
	}
	setRegisterState(REGISTERING);

	var message = {
		id : 'register',
		name : name
	};
	sendMessage(message);
	var message = {
		id : 'userlist',
	};
	sendMessage(message);
	/*document.getElementById('peer').focus();*/
}
function register2(name) {
	if (name == '') {
		window.alert('ニックネームを登録してくださ');
		location.href = 'https://live.jvideo.club/editnickname'
		return;
	}else{
		window.alert(name);
	}
	setRegisterState(REGISTERING);

	var message = {
		id : 'register',
		name : name
	};
	sendMessage(message);
	document.getElementById('peer').focus();
}

function call() {
	if (document.getElementById('peer2').value == '') {
		window.alert('You must specify the peer name');
		return;
	}
	setCallState(PROCESSING_CALL);
	showSpinner(videoInput, videoOutput);

	var options = {
		localVideo : videoInput,
		remoteVideo : videoOutput,
		onicecandidate : onIceCandidate,
		onerror : onError
	}
	webRtcPeer = new kurentoUtils.WebRtcPeer.WebRtcPeerSendrecv(options,
			function(error) {
				if (error) {
					return console.error(error);
				}
				webRtcPeer.generateOffer(onOfferCall);
			});
}

function onOfferCall(error, offerSdp) {
	if (error)
		return console.error('Error generating the offer');
	var message = {
		id : 'call',
		from : document.getElementById('name').value,
		to : document.getElementById('peer2').value,
		sdpOffer : offerSdp
	};
	sendMessage(message);
}

function userlist(message){
/*	ar = message.userlist.split(',');
	var ulist = "";
	for(let v of ar) {
  		ulist =ulist + "<option value='"+v+"'>"+v+"</option>";
	}
*/
var ulist = "<option value='"+tel+"'>"+tel+"</option>";
//document.getElementById("peer").innerHTML="<select id='peer2' name='peer'>"+ulist+"</select>";
document.getElementById("peer").innerHTML='<input id="peer2" name="peer" class="form-control" type="hidden" value="'+tel+'"></input>'
}

function stop(message) {
	setCallState(NO_CALL);
	if (webRtcPeer) {
		webRtcPeer.dispose();
		webRtcPeer = null;

		if (!message) {
			var message = {
				id : 'stop'
			}
			sendMessage(message);
		}
	}
	hideSpinner(videoInput, videoOutput);
	location.replace('https://rabitalk.jvideo.club/home');
}

function stop2(message) {
        setCallState(NO_CALL);
        if (webRtcPeer) {
                webRtcPeer.dispose();
                webRtcPeer = null;

                if (!message) {
                        var message = {
                                id : 'stop'
                        }
                        sendMessage(message);
                }
        }
        hideSpinner(videoInput, videoOutput);
}

function onError() {
	setCallState(NO_CALL);
}

function onIceCandidate(candidate) {

	var message = {
		id : 'onIceCandidate',
		candidate : candidate
	};
	sendMessage(message);
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

function disableButton(id) {
	$(id).attr('disabled', true);
	$(id).removeAttr('onclick');
	if(id=='#register'){
document.getElementById("area1").innerText = "ONLINE中";
	}
}

function enableButton(id, functionName) {
	$(id).attr('disabled', false);
	$(id).attr('onclick', functionName);
}

/**
 * Lightbox utility (to display media pipeline image in a modal dialog)
 */
$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});
