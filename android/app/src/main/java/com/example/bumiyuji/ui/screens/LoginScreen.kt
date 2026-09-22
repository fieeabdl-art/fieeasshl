package com.example.bumiyuji.ui.screens

import androidx.compose.foundation.Image
import androidx.compose.foundation.background
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Brush
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.res.painterResource
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.input.PasswordVisualTransformation
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiButton
import com.example.bumiyuji.ui.components.BumiyujiTextField
import com.example.bumiyuji.ui.theme.DarkCharcoal
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.LoginViewModel

@Composable
fun LoginScreen(
    viewModel: LoginViewModel,
    onLoginSuccess: () -> Unit
) {
    val uiState = viewModel.uiState

    LaunchedEffect(uiState) {
        if (uiState is UiState.Success) {
            onLoginSuccess()
        }
    }

    Box(modifier = Modifier.fillMaxSize().background(WarmCream)) {
        // Background decorative element (optional, could be an image if available)
        Box(
            modifier = Modifier
                .fillMaxWidth()
                .fillMaxHeight(0.4f)
                .background(
                    Brush.verticalGradient(
                        colors = listOf(DarkCharcoal, DarkCharcoal.copy(alpha = 0.8f))
                    )
                )
        )

        Column(
            modifier = Modifier
                .fillMaxSize()
                .padding(24.dp),
            horizontalAlignment = Alignment.CenterHorizontally,
            verticalArrangement = Arrangement.Center
        ) {
            // Logo / Title area
            Surface(
                modifier = Modifier
                    .size(100.dp)
                    .clip(RoundedCornerShape(20.dp)),
                color = GoldAccent
            ) {
                Box(contentAlignment = Alignment.Center) {
                    Text(
                        text = "BY",
                        style = MaterialTheme.typography.headlineLarge,
                        color = DarkCharcoal,
                        fontWeight = FontWeight.Black
                    )
                }
            }

            Spacer(modifier = Modifier.height(24.dp))

            Text(
                text = "Bumiyuji Living",
                style = MaterialTheme.typography.headlineMedium,
                color = if (uiState is UiState.Loading) Color.Gray else DarkCharcoal,
                fontWeight = FontWeight.Bold
            )

            Text(
                text = "Admin Content Management System",
                style = MaterialTheme.typography.bodyMedium,
                color = Color.Gray
            )

            Spacer(modifier = Modifier.height(48.dp))

            // Login Card
            Surface(
                modifier = Modifier.fillMaxWidth(),
                shape = RoundedCornerShape(24.dp),
                color = Color.White,
                shadowElevation = 8.dp
            ) {
                Column(
                    modifier = Modifier.padding(24.dp)
                ) {
                    Text(
                        text = "Selamat Datang",
                        style = MaterialTheme.typography.titleLarge,
                        fontWeight = FontWeight.Bold,
                        color = DarkCharcoal
                    )
                    Text(
                        text = "Silakan login untuk mengelola konten",
                        style = MaterialTheme.typography.bodySmall,
                        color = Color.Gray
                    )

                    Spacer(modifier = Modifier.height(32.dp))

                    BumiyujiTextField(
                        value = viewModel.email,
                        onValueChange = { viewModel.email = it },
                        label = "Email Address",
                        isError = uiState is UiState.Error && viewModel.email.isEmpty()
                    )

                    Spacer(modifier = Modifier.height(16.dp))

                    BumiyujiTextField(
                        value = viewModel.password,
                        onValueChange = { viewModel.password = it },
                        label = "Password",
                        visualTransformation = PasswordVisualTransformation(),
                        isError = uiState is UiState.Error
                    )

                    if (uiState is UiState.Error) {
                        Spacer(modifier = Modifier.height(16.dp))
                        Text(
                            text = uiState.message,
                            color = MaterialTheme.colorScheme.error,
                            style = MaterialTheme.typography.bodySmall
                        )
                    }

                    Spacer(modifier = Modifier.height(32.dp))

                    BumiyujiButton(
                        text = "Login",
                        onClick = { viewModel.login() },
                        isLoading = uiState is UiState.Loading
                    )
                }
            }
        }
    }
}
