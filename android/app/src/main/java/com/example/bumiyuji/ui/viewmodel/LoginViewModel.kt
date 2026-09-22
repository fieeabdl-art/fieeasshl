package com.example.bumiyuji.ui.viewmodel

import androidx.compose.runtime.getValue
import androidx.compose.runtime.mutableStateOf
import androidx.compose.runtime.setValue
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.example.bumiyuji.data.api.LoginRequest
import com.example.bumiyuji.data.api.LoginResponse
import com.example.bumiyuji.data.repository.AuthRepository
import com.example.bumiyuji.ui.UiState
import kotlinx.coroutines.launch

class LoginViewModel(private val repository: AuthRepository) : ViewModel() {

    var email by mutableStateOf("")
    var password by mutableStateOf("")
    var uiState by mutableStateOf<UiState<LoginResponse>>(UiState.Idle)

    fun login() {
        if (email.isBlank() || password.isBlank()) {
            uiState = UiState.Error("Email and password are required")
            return
        }

        viewModelScope.launch {
            uiState = UiState.Loading

            val request = LoginRequest(email, password, "Android Device")
            val result = repository.login(request)

            uiState = if (result.isSuccess) {
                UiState.Success(result.getOrThrow())
            } else {
                UiState.Error(result.exceptionOrNull()?.message ?: "Unknown error")
            }
        }
    }
}
