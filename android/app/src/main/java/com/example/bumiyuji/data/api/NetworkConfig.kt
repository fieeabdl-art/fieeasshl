package com.example.bumiyuji.data.api

object NetworkConfig {
    enum class Environment(val baseUrl: String, val description: String) {
        LOCAL_EMULATOR("http://10.0.2.2:8000/api/", "Android Emulator Localhost"),
        PHYSICAL_DEVICE("http://192.168.18.121:8000/api/", "Local Wi-Fi/LAN Physical Device"),
        PRODUCTION("https://bumiyuji.com/api/", "Production Server (HTTPS)")
    }

    /**
     * Lingkungan aktif untuk networking API.
     * Ganti ke Environment.PHYSICAL_DEVICE atau PRODUCTION sesuai kebutuhan.
     */
    var currentEnvironment: Environment = Environment.LOCAL_EMULATOR

    val baseUrl: String
        get() = currentEnvironment.baseUrl
}
