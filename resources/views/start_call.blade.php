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
    const signalingServerUrl = 'https://deluxehospital.com/signaling';
    const localVideo = document.getElementById('localVideo');
    const remoteVideo = document.getElementById('remoteVideo');
    let localStream;
    let peerConnection;
    let peerId = Math.random().toString(36).substring(2);

    async function start() {
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
    }

    async function handleIncomingMessage(message) {
      const data = JSON.parse(message.data);
      if (data.type === 'offer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
        const answer = await peerConnection.createAnswer();
        await peerConnection.setLocalDescription(answer);
        sendToServer({ type: 'answer', sdp: answer });
      } else if (data.type === 'answer') {
        await peerConnection.setRemoteDescription(new RTCSessionDescription(data.sdp));
      } else if (data.type === 'candidate') {
        await peerConnection.addIceCandidate(new RTCIceCandidate(data.candidate));
      }
    }

    async function sendToServer(message) {
      const response = await fetch(signalingServerUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ peer_id: peerId, ...message })
      });

      const result = await response.json();
      console.log(result);
    }

    async function pollServer() {
      setInterval(async () => {
        const response = await fetch(`${signalingServerUrl}?peer_id=${peerId}`);
        const data = await response.json();
        if (data.status === 'ok' && data.peer_id !== peerId) {
          await handleIncomingMessage({ data: JSON.stringify(data) });
        }
      }, 3000);
    }

    start();
    pollServer();
  </script>
</body>
</html>