package com.example.bumiyuji.data.repository

import com.example.bumiyuji.data.api.ApiService
import com.example.bumiyuji.data.api.LoginRequest
import com.example.bumiyuji.data.api.LoginResponse
import com.example.bumiyuji.data.local.SessionManager
import retrofit2.Response

class AuthRepository(
    private val apiService: ApiService,
    private val sessionManager: SessionManager
) {
    suspend fun login(request: LoginRequest): Result<LoginResponse> {
        return try {
            val response = apiService.login(request)
            if (response.isSuccessful && response.body() != null) {
                val body = response.body()!!
                sessionManager.saveAuthToken(body.token)
                sessionManager.saveAdminInfo(body.admin.name, body.admin.role)
                Result.success(body)
            } else {
                Result.failure(Exception(response.errorBody()?.string() ?: "Login failed"))
            }
        } catch (e: Exception) {
            Result.failure(e)
        }
    }

    suspend fun logout(): Result<Unit> {
        return try {
            apiService.logout()
            sessionManager.clearSession()
            Result.success(Unit)
        } catch (e: Exception) {
            sessionManager.clearSession() // Still clear local session on network error
            Result.failure(e)
        }
    }

    fun getAuthToken() = sessionManager.authToken
}
