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

API_URL = "http://127.0.0.1:8000/api/sensor"

# ==========================
# MQTT Callback
# ==========================

def on_connect(client, userdata, flags, rc):
    print("Connected :", rc)
    client.subscribe(MQTT_TOPIC)


def on_message(client, userdata, msg):

    try:

        payload = json.loads(msg.payload.decode())

        print("\n========== MQTT ==========")
        print("Message ID :", payload.get("message_id"))
        print("Device ID  :", payload.get("device_id"))
        print("Timestamp  :", payload.get("timestamp"))
        print("Node Status:", payload.get("status", {}).get("node_status"))
        print("IP Address :", payload.get("status", {}).get("ip"))

        data = payload.get("data", {})

        sensor = {
            "suhu": data.get("suhu"),
            "ph": data.get("ph"),
            "kekeruhan": data.get("turbidity_ntu")
        }

        print("----------------------------")
        print("Data Sensor")
        print(sensor)

        response = requests.post(API_URL, json=sensor)

        print("\nLaravel :", response.status_code)
        print(response.text)

    except Exception as e:
        print("ERROR :", e)


# ==========================
# MQTT Client
# ==========================

client = mqtt.Client()

client.username_pw_set(MQTT_USER, MQTT_PASS)

client.tls_set()

client.on_connect = on_connect
client.on_message = on_message

client.connect(MQTT_BROKER, MQTT_PORT, 60)

client.loop_forever()