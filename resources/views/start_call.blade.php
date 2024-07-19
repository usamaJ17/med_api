<!DOCTYPE html>
<html>
<head>
  <title>WebRTC Test</title>
  <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
  <style>
    video {
      width: 45%;
      margin: 2%;
      border: 1px solid black;
    }
  </style>
</head>
<body>
  <h1>WebRTC Test</h1>
  <video id="localVideo" autoplay playsinline></video>
  <video id="remoteVideo" autoplay playsinline></video>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const sessionId = "{{ $sessionId }}";
    
    const signalingServerUrl = `https://deluxehospital.com/signaling/${sessionId}`;
    const localVideo = document.getElementById('localVideo');
    const remoteVideo = document.getElementById('remoteVideo');
    let localStream;
    let peerConnection;
    let peerId = Math.random().toString(36).substring(2);

    async function start() {
      try {
        localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localVideo.srcObject = localStream;

        peerConnection = new RTCPeerConnection({
          iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
        });

        localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
        peerConnection.ontrack = event => {
          if (event.streams && event.streams[0]) {
            remoteVideo.srcObject = event.streams[0];
          }
        };

        peerConnection.onicecandidate = event => {
          if (event.candidate) {
            sendToServer({ type: 'candidate', candidate: event.candidate });
          }
        };

        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        sendToServer({ type: 'offer', sdp: offer });

        pollServer();
      } catch (error) {
        console.error('Error accessing media devices.', error);
      }
    }

    async function handleIncomingMessage(message) {
      if (message.type === 'offer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription(message.sdp));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        sendToServer({ type: 'answer', sdp: answer });
      } else if (message.type === 'answer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription(message.sdp));
      } else if (message.type === 'candidate') {
        await peerConnection.addIceCandidate(new RTCIceCandidate(message.candidate));
      }
    }

    async function sendToServer(message) {
      try {
        const response = await fetch(signalingServerUrl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ peer_id: peerId, ...message })
        });
        const result = await response.json();
        console.log(result);
      } catch (error) {
        console.error('Error sending message to server.', error);
      }
    }

    async function pollServer() {
      setInterval(async () => {
        try {
          const response = await fetch(`${signalingServerUrl}?peer_id=${peerId}`);
          const data = await response.json();
          if (data.status === 'ok' && data.peer_id !== peerId) {
            await handleIncomingMessage(data);
          }
        } catch (error) {
          console.error('Error polling server.', error);
        }
      }, 3000);
    }

    start();
  </script>
</body>
</html>
