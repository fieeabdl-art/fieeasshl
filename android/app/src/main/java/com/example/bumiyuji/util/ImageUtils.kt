package com.example.bumiyuji.util

import com.example.bumiyuji.data.api.NetworkConfig

object ImageUtils {
    fun resolveImageUrl(url: String?): String? {
        if (url.isNullOrEmpty()) return null

        // If it's already an absolute HTTP URL, return as is
        if (url.startsWith("http://") || url.startsWith("https://")) {
            // But if it contains localhost/127.0.0.1 and we are in emulator, fix it
            if (NetworkConfig.currentEnvironment == NetworkConfig.Environment.LOCAL_EMULATOR) {
                return url.replace("localhost", "10.0.2.2")
                          .replace("127.0.0.1", "10.0.2.2")
            }
            return url
        }

        // If it starts with /storage/, prepend base server URL
        val baseServerUrl = NetworkConfig.baseUrl.substringBefore("/api")
        return if (url.startsWith("/")) {
            "$baseServerUrl$url"
        } else {
            "$baseServerUrl/$url"
        }
    }
}
