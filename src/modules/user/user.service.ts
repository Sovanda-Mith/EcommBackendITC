import { Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { User } from 'src/users/user.entity';
import { Repository } from 'typeorm';
import { CreateUserDto } from './dto/create-user.dto';
import { UpdateUserDto } from './dto/update-user.dto';

@Injectable()
export class UserService {
  constructor(
    @InjectRepository(User)
    private usersRepo: Repository<User>,
  ) {}

  getAllUsers() {
    return this.usersRepo.find({ relations: ['tasks'] });
  }

  async getUserById(id: number) {
    const user = await this.usersRepo.findOne({
      where: { id },
      relations: ['tasks'],
    });
    if (!user) {
      throw new NotFoundException(`User with id ${id} not found`);
    }
    return user;
  }

  async getUser(username: string) {
    const user = await this.usersRepo.findOne({
      where: { username },
      relations: ['tasks'],
    });
    if (!user) {
      throw new NotFoundException(`User with username ${username} not found`);
    }
    return user;
  }

  createUser(createUserDto: CreateUserDto) {
    const user = this.usersRepo.create(createUserDto);
    return this.usersRepo.save(user);
  }

  updateUser(username: string, updateUserDto: UpdateUserDto) {
    return this.usersRepo.update({ username }, updateUserDto);
  }

  deleteUser(username: string) {
    return this.usersRepo.delete({ username });
  }
}
