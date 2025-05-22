import {
  Get,
  Param,
  Controller,
  Post,
  Body,
  Patch,
  Delete,
} from '@nestjs/common';
import { UserService } from './user.service';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserDto } from './dto/update-user.dto';

@Controller('users')
export class UserController {
  constructor(private readonly userService: UserService) {}

  @Get()
  getAllUsers(): any {
    return this.userService.getAllUsers();
  }

  @Get('/users/:id')
  getUserById(@Param('id') id: number): any {
    return this.userService.getUserById(id);
  }

  @Get('/:username')
  getUser(@Param('username') username: string): any {
    return this.userService.getUser(username);
  }

  @Post('/users')
  createUser(@Body() CreateUserDto: CreateUserDto): any {
    return this.userService.createUser(CreateUserDto);
  }

  @Patch('/users/:username')
  updateUser(
    @Param('username') username: string,
    @Body() updateUserDto: UpdateUserDto,
  ): any {
    return this.userService.updateUser(username, updateUserDto);
  }

  @Delete('/users/:username')
  deleteUser(@Param('username') username: string): any {
    return this.userService.deleteUser(username);
  }
}
