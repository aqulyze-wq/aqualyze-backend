# ================================================================
# Nama Sistem  : Aqualyze - Smart Water Monitoring System
# Author       : Refan Rustoni Putra (10824005),
#                Andini Putri Yani (10824011)
# Versi        : 1.4.2
# Tahun        : 2026
# ================================================================

import json
import requests
import paho.mqtt.client as mqtt

# ==========================
# MQTT Configuration
# ==========================
MQTT_BROKER = "fcb0ad941e3f418f8dc1d16332c8fcb9.s1.eu.hivemq.cloud"
MQTT_PORT = 8883
MQTT_USER = "aqualyze"
MQTT_PASS = "aqualyze123"
MQTT_TOPIC = "monitoringair/data"

# ==========================
# Laravel API
# ==========================
# Cukup kirim ke Sensor API karena SensorController sudah memproses data Device & Sensor sekaligus!
SENSOR_API = "http://127.0.0.1:8000/api/sensor"


# ==========================
# MQTT Callbacks
# ==========================
def on_connect(client, userdata, flags, rc, properties=None):
    if rc == 0:
        print(" Connected to MQTT Broker HiveMQ!")
        client.subscribe(MQTT_TOPIC)
        print(f" Subscribed to topic: {MQTT_TOPIC}\n")
    else:
        print(f" Connection failed with code {rc}")


def on_message(client, userdata, msg):
    try:
        # Decode JSON payload
        payload = json.loads(msg.payload.decode('utf-8'))

        print("\n========================================")
        print(" MQTT MESSAGE RECEIVED")
        print("========================================")

        device_id = payload.get("device_id")
        lokasi = payload.get("lokasi")
        timestamp = payload.get("timestamp")

        status = payload.get("status", {})
        location = payload.get("location", {})
        data = payload.get("data", {})

        print(f"Device ID   : {device_id}")
        print(f"Lokasi      : {lokasi}")
        print(f"Timestamp   : {timestamp}")
        print(f"Node Status : {status.get('node_status')}")
        print(f"IP          : {status.get('ip')}")
        print(f"Lat / Long  : {location.get('latitude')}, {location.get('longitude')}")

        print("----------------------------------------")
        print("Sensor Values:")
        print(f"Suhu        : {data.get('suhu')} °C ({data.get('status_suhu')})")
        print(f"pH          : {data.get('ph')} ({data.get('status_ph')})")
        print(f"Kekeruhan   : {data.get('turbidity_ntu')} NTU ({data.get('status_kekeruhan')})")

        # Format Payload yang dikirim ke Laravel API
        sensor_payload = {
            "device_id": device_id,
            "lokasi": lokasi,
            "data": {
                "suhu": data.get("suhu"),
                "ph": data.get("ph"),
                "turbidity_ntu": data.get("turbidity_ntu"),
                "status_suhu": data.get("status_suhu"),
                "status_ph": data.get("status_ph"),
                "status_kekeruhan": data.get("status_kekeruhan")
            },
            "status": {
                "node_status": status.get("node_status"),
                "ip": status.get("ip")
            },
            "location": {
                "latitude": location.get("latitude"),
                "longitude": location.get("longitude"),
                "altitude_mdpl": location.get("altitude_mdpl")
            }
        }

        # Send Request to Laravel API
        headers = {'Content-Type': 'application/json', 'Accept': 'application/json'}
        sensor_response = requests.post(
            SENSOR_API,
            json=sensor_payload,
            headers=headers,
            timeout=10
        )

        print("\n========== LARAVEL API RESPONSE ==========")
        print("Status Code :", sensor_response.status_code)
        print("Response    :", sensor_response.text)
        print("========================================\n")

    except Exception as e:
        print("\n========================================")
        print(" ERROR PROCESSING MESSAGE")
        print("========================================")
        print("Error details:", str(e))


# ==========================
# MQTT Client Setup
# ==========================
# Kompatibel dengan paho-mqtt v1 dan v2
try:
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)
except AttributeError:
    client = mqtt.Client()

client.username_pw_set(MQTT_USER, MQTT_PASS)

# Setup TLS untuk HiveMQ Cloud
client.tls_set()

client.on_connect = on_connect
client.on_message = on_message

print("Connecting to HiveMQ Broker...")
client.connect(MQTT_BROKER, MQTT_PORT, 60)

client.loop_forever()