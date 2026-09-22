package com.example.bumiyuji.ui.screens

import android.net.Uri
import androidx.activity.compose.rememberLauncherForActivityResult
import androidx.activity.result.contract.ActivityResultContracts
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.horizontalScroll
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.rememberScrollState
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
import com.example.bumiyuji.ui.viewmodel.ProjectViewModel
import com.example.bumiyuji.util.FileUtils
import com.example.bumiyuji.util.ImageUtils
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody.Companion.asRequestBody

@OptIn(ExperimentalMaterial3Api::class)
@Composable
fun ProjectFormScreen(
    viewModel: ProjectViewModel,
    projectId: Int? = null,
    onNavigateBack: () -> Unit
) {
    var name by remember { mutableStateOf("") }
    var client by remember { mutableStateOf("") }
    var location by remember { mutableStateOf("") }
    var category by remember { mutableStateOf("") }
    var description by remember { mutableStateOf("") }
    var startDate by remember { mutableStateOf("") }
    var deadline by remember { mutableStateOf("") }
    var status by remember { mutableStateOf("pending") }
    var progress by remember { mutableStateOf(0f) }
    var selectedImageUri by remember { mutableStateOf<Uri?>(null) }
    var existingImageUrl by remember { mutableStateOf<String?>(null) }

    val context = LocalContext.current
    val launcher = rememberLauncherForActivityResult(
        contract = ActivityResultContracts.GetContent()
    ) { uri: Uri? ->
        selectedImageUri = uri
    }

    // Load data if in Edit mode
    LaunchedEffect(projectId) {
        if (projectId != null) {
            viewModel.fetchDetail(projectId)
        }
    }

    val detailState = viewModel.detailUiState
    LaunchedEffect(detailState) {
        if (projectId != null && detailState is UiState.Success) {
            val project = detailState.data
            name = project.name
            client = project.client
            location = project.location ?: ""
            category = project.category ?: ""
            description = project.description ?: ""
            startDate = project.start_date ?: ""
            deadline = project.deadline ?: ""
            status = project.status
            progress = project.progress.toFloat()
            existingImageUrl = project.cover_image
        }
    }

    Scaffold(
        topBar = {
            BumiyujiTopBar(
                title = if (projectId == null) "Tambah Project" else "Edit Project",
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
            verticalArrangement = Arrangement.spacedBy(20.dp)
        ) {
            BumiyujiTextField(value = name, onValueChange = { name = it }, label = "Nama Project *")
            BumiyujiTextField(value = client, onValueChange = { client = it }, label = "Client *")
            BumiyujiTextField(value = location, onValueChange = { location = it }, label = "Lokasi")
            BumiyujiTextField(value = category, onValueChange = { category = it }, label = "Kategori")

            Row(horizontalArrangement = Arrangement.spacedBy(16.dp)) {
                BumiyujiTextField(value = startDate, onValueChange = { startDate = it }, label = "Mulai (YYYY-MM-DD)", modifier = Modifier.weight(1f))
                BumiyujiTextField(value = deadline, onValueChange = { deadline = it }, label = "Deadline (YYYY-MM-DD)", modifier = Modifier.weight(1f))
            }

            Column {
                Text(text = "Status", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(8.dp))
                Row(modifier = Modifier.horizontalScroll(rememberScrollState()), horizontalArrangement = Arrangement.spacedBy(8.dp)) {
                    val statuses = listOf("pending", "berjalan", "selesai", "dibatalkan")
                    statuses.forEach { s ->
                        CategoryChip(selected = status == s, text = s.uppercase(), onClick = { status = s })
                    }
                }
            }

            Column {
                Row(verticalAlignment = Alignment.CenterVertically) {
                    Text(text = "Progress", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                    Spacer(modifier = Modifier.weight(1f))
                    Text(text = "${progress.toInt()}%", fontWeight = FontWeight.Bold, color = GoldAccent)
                }
                Slider(
                    value = progress,
                    onValueChange = { progress = it },
                    valueRange = 0f..100f,
                    colors = SliderDefaults.colors(thumbColor = GoldAccent, activeTrackColor = GoldAccent)
                )
            }

            BumiyujiTextField(value = description, onValueChange = { description = it }, label = "Deskripsi", singleLine = false, modifier = Modifier.heightIn(min = 100.dp))

            Column {
                Text(text = "Cover Image", style = MaterialTheme.typography.titleSmall, fontWeight = FontWeight.Bold)
                Spacer(modifier = Modifier.height(12.dp))
                Box(
                    modifier = Modifier
                        .fillMaxWidth()
                        .height(180.dp)
                        .clip(RoundedCornerShape(16.dp))
                        .background(Color.White)
                        .border(1.dp, Color.Gray.copy(alpha = 0.3f), RoundedCornerShape(16.dp))
                        .clickable { launcher.launch("image/*") },
                    contentAlignment = Alignment.Center
                ) {
                    if (selectedImageUri != null) {
                        AsyncImage(model = selectedImageUri, contentDescription = null, modifier = Modifier.fillMaxSize(), contentScale = ContentScale.Crop)
                    } else if (!existingImageUrl.isNullOrEmpty()) {
                        AsyncImage(model = ImageUtils.resolveImageUrl(existingImageUrl), contentDescription = null, modifier = Modifier.fillMaxSize(), contentScale = ContentScale.Crop)
                    } else {
                        Icon(Icons.Default.CloudUpload, contentDescription = null, tint = GoldAccent, modifier = Modifier.size(48.dp))
                    }
                }
            }

            BumiyujiButton(
                text = if (projectId == null) "Simpan Project" else "Perbarui Project",
                onClick = {
                    val imagePart = selectedImageUri?.let { uri ->
                        val file = FileUtils.uriToFile(uri, context)
                        val requestFile = file.asRequestBody("image/*".toMediaTypeOrNull())
                        MultipartBody.Part.createFormData("cover_image", file.name, requestFile)
                    }
                    if (projectId == null) {
                        viewModel.createProject(name, client, location, category, startDate, deadline, status, progress.toInt(), description, imagePart)
                    } else {
                        viewModel.updateProject(projectId, name, client, location, category, startDate, deadline, status, progress.toInt(), description, imagePart)
                    }
                    onNavigateBack()
                },
                isLoading = viewModel.projectsUiState is UiState.Loading || viewModel.detailUiState is UiState.Loading
            )
        }
    }
}
