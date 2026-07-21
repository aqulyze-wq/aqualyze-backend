# ================================================================
# Nama Sistem  : Aqualyze - Smart Water Monitoring System
# Author       : Refan Rustoni Putra (10824005),
#                Andini Putri Yani (10824011)
# Versi        : 1.4.1
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

SENSOR_API = "http://127.0.0.1:8000/api/sensor"
DEVICE_API = "http://127.0.0.1:8000/api/device/update"

# ==========================
# MQTT Callback
# ==========================

def on_connect(client, userdata, flags, rc):
    print("Connected :", rc)
    client.subscribe(MQTT_TOPIC)


def on_message(client, userdata, msg):

    try:

        payload = json.loads(msg.payload.decode())

        print("\n========================================")
        print("MQTT MESSAGE")
        print("========================================")

        device_id = payload.get("device_id")
        timestamp = payload.get("timestamp")

        status = payload.get("status", {})
        location = payload.get("location", {})
        data = payload.get("data", {})

        print("Device ID :", device_id)
        print("Timestamp :", timestamp)
        print("Status    :", status.get("node_status"))
        print("IP        :", status.get("ip"))

        print("Latitude  :", location.get("latitude"))
        print("Longitude :", location.get("longitude"))
        print("Altitude  :", location.get("altitude_mdpl"))

        print("----------------------------------------")
        print("Sensor")
        print("----------------------------------------")

        print("Suhu       :", data.get("suhu"))
        print("pH         :", data.get("ph"))
        print("Kekeruhan  :", data.get("turbidity_ntu"))

        # =====================================
        # Update Device
        # =====================================

        device_payload = {

            "device_id": device_id,
            "status": status.get("node_status"),
            "ip": status.get("ip"),
            "latitude": location.get("latitude"),
            "longitude": location.get("longitude"),
            "altitude": location.get("altitude_mdpl")

        }

        print("\n========== DEVICE API ==========")
        print(device_payload)

        device_response = requests.post(
            DEVICE_API,
            json=device_payload,
            timeout=10
        )

        print("Status Code :", device_response.status_code)
        print("Response :")
        print(device_response.text)

        # =====================================
        # Kirim Sensor
        # =====================================

        sensor_payload = {

            "device_id": device_id,

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

        print("\n========== SENSOR PAYLOAD ==========")
        print(json.dumps(sensor_payload, indent=4))

        sensor_response = requests.post(
            SENSOR_API,
            json=sensor_payload,
            timeout=10
        )

        print("Status Code :", sensor_response.status_code)
        print("Response :")
        print(sensor_response.text)

        print("\n========================================")
        print("SELESAI")
        print("========================================")

    except Exception as e:

        print("\n========================================")
        print("ERROR")
        print("========================================")
        print(e)


# ==========================
# MQTT Client
# ==========================

client = mqtt.Client()

client.username_pw_set(
    MQTT_USER,
    MQTT_PASS
)

client.tls_set()

client.on_connect = on_connect
client.on_message = on_message

client.connect(
    MQTT_BROKER,
    MQTT_PORT,
    60
)

client.loop_forever()