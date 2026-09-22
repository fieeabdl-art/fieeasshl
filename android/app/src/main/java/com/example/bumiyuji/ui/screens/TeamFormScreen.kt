package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.foundation.verticalScroll
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.CloudUpload
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.platform.LocalContext
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import coil.compose.AsyncImage
import com.example.bumiyuji.ui.UiState
import com.example.bumiyuji.ui.components.BumiyujiButton
import com.example.bumiyuji.ui.components.BumiyujiTextField
import com.example.bumiyuji.ui.components.BumiyujiTopBar
import com.example.bumiyuji.ui.theme.GoldAccent
import com.example.bumiyuji.ui.theme.WarmCream
import com.example.bumiyuji.ui.viewmodel.TeamViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun TeamFormScreen(
    viewModel: TeamViewModel,
    profileId: Int? = null,
    onNavigateBack: () -> Unit
) {
    var name by remember { mutableStateOf("") }
    var position by remember { mutableStateOf("") }
    var instagram by remember { mutableStateOf("") }
    var linkedin by remember { mutableStateOf("") }
    var selectedImageUri by remember { mutableStateOf<Uri?>(null) }
    var existingImageUrl by remember { mutableStateOf<String?>(null) }

    val context = LocalContext.current
    val launcher = rememberLauncherForActivityResult(ActivityResultContracts.GetContent()) { selectedImageUri = it }

    LaunchedEffect(profileId) {
        if (profileId != null) {
            viewModel.fetchDetail(profileId)
        }
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (profileId != null && detailState is UiState.Success) {
            val profile = detailState.data
            name = profile.name
            position = profile.position ?: ""
            instagram = profile.instagram ?: ""
            linkedin = profile.linkedin ?: ""
            existingImageUrl = profile.image_url
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = if (profileId == null) "Tambah Tim" else "Edit Tim",
                onBackClick = onNavigateBack
            )
        },
        containerColor = WarmCream
    ) { innerPadding ->
        Column(
            modifier = Modifier
                .padding(innerPadding)
                .fillMaxSize()
                .padding(24.dp)
                .verticalScroll(rememberScrollState()),
            verticalArrangement = Arrangement.spacedBy(20.dp),
            horizontalAlignment = Alignment.CenterHorizontally
        ) {
            Box(
                modifier = Modifier
                    .size(120.dp)
                    .clip(CircleShape)
                    .background(Color.White)
                    .border(2.dp, GoldAccent.copy(alpha = 0.3f), CircleShape)
                    .clickable { launcher.launch("image/*") },
                contentAlignment = Alignment.Center
            ) {
                if (selectedImageUri != null) {
                    AsyncImage(
                        model = selectedImageUri,
                        contentDescription = null,
                        modifier = Modifier.fillMaxSize(),
                        contentScale = ContentScale.Crop
                    )
                } else if (existingImageUrl != null) {
                    AsyncImage(
                        model = ImageUtils.resolveImageUrl(existingImageUrl),
                        contentDescription = null,
                        modifier = Modifier.fillMaxSize(),
                        contentScale = ContentScale.Crop
                    )
                } else {
                    Icon(Icons.Default.CloudUpload, contentDescription = null, tint = GoldAccent)
                }
            }
            Text(text = "Pilih Foto Profil", style = MaterialTheme.typography.labelSmall, color = Color.Gray)

            BumiyujiTextField(value = name, onValueChange = { name = it }, label = "Nama Lengkap *")
            BumiyujiTextField(value = position, onValueChange = { position = it }, label = "Jabatan")
            BumiyujiTextField(value = instagram, onValueChange = { instagram = it }, label = "Instagram URL")
            BumiyujiTextField(value = linkedin, onValueChange = { linkedin = it }, label = "LinkedIn URL")

            Spacer(modifier = Modifier.height(12.dp))

            BumiyujiButton(
                text = "Simpan Perubahan",
                onClick = {
                    val nameBody = RequestBody.create(MultipartBody.FORM, name)
                    val posBody = RequestBody.create(MultipartBody.FORM, position)
                    val igBody = RequestBody.create(MultipartBody.FORM, instagram)
                    val liBody = RequestBody.create(MultipartBody.FORM, linkedin)

                    val imagePart = selectedImageUri?.let { uri ->
                        val file = FileUtils.uriToFile(uri, context)
                        val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                        MultipartBody.Part.createFormData("image_path", file.name, requestFile)
                    }

                    if (profileId == null) {
                        viewModel.createTeamProfile(nameBody, posBody, igBody, liBody, imagePart, null, null)
                    } else {
                        viewModel.updateTeamProfile(profileId, nameBody, posBody, igBody, liBody, imagePart, null, null)
                    }
                    onNavigateBack()
                },
                isLoading = detailState is UiState.Loading
            )
        }
    }
}
